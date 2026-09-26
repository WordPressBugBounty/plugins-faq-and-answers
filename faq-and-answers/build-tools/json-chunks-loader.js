/**
 * Emits a large JSON file as a series of statements instead of one expression.
 *
 * Why this exists
 * ---------------
 * bpl-tools' IconLibrary statically imports three icon sets — font-awesome.json
 * (1.8 MB), bootstrap.json (1.4 MB) and lucidicons.json (166 KB). Webpack turns
 * each of them into a single object literal, and a single object literal is a
 * single expression, so Terser's `max_line_len` cannot break it: it is only
 * allowed to insert a newline where one is already legal, which means between
 * statements. The result was build/index.js carrying one 3.19 MB line.
 *
 * A line that long is valid JavaScript and browsers do not care, but the plugin
 * review's automated scanner reads code line by line against a per-line budget,
 * and a line over the budget is skipped rather than reviewed — which comes back
 * as a finding instead of a pass.
 *
 * What it does
 * ------------
 * The data is re-serialised and pushed onto an array in bounded pieces, so the
 * module body becomes a few hundred ordinary statements that Terser is free to
 * break apart. JSON.parse then puts the value back together at import time.
 *
 * What it does not change
 * -----------------------
 * The imported value is deep-equal to the original file, so every consumer sees
 * exactly what it saw before. The bundle grows only by the newlines and the
 * per-statement overhead — well under a percent — and JSON.parse on a string is
 * if anything quicker for the engine than an object literal of the same data.
 *
 * This is a workaround for the line length, not for the size. 3.35 MB of icons
 * still ship in the editor bundle; getting them out means teaching IconLibrary
 * to fetch them at runtime, which is a change in bpl-tools and affects every
 * plugin built on it.
 */

/** Characters per statement. ~9k review tokens per line, against a 90k limit. */
const CHUNK_SIZE = 20000;

module.exports = function jsonChunksLoader(source) {
	// The value has to survive a parse/serialise round trip unchanged, so parse
	// it here rather than slicing the raw text: that also normalises whitespace
	// and lets an unparseable file fail the build loudly instead of emitting
	// something that breaks at import time.
	const json = JSON.stringify(JSON.parse(source));

	const statements = [];

	for (let at = 0; at < json.length; at += CHUNK_SIZE) {
		// JSON.stringify on the piece, not hand written quoting: it escapes
		// quotes, backslashes and control characters, and a piece that happens
		// to split a surrogate pair is re-escaped either side of the boundary
		// and joins back into the same pair.
		statements.push(`p.push(${JSON.stringify(json.slice(at, at + CHUNK_SIZE))});`);
	}

	return [
		'/* Split into statements at build time — see build-tools/json-chunks-loader.js */',
		'var p = [];',
		...statements,
		'module.exports = JSON.parse(p.join(""));',
	].join('\n');
};
