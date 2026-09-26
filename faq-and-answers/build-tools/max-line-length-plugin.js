/**
 * Fails the build if any emitted JavaScript file carries a line that is too
 * long to be reviewed.
 *
 * Why this exists
 * ---------------
 * The plugin review runs an automated scanner that reads JavaScript line by
 * line against a per-line token budget (90,000 at the time of writing). A line
 * over the budget is not reviewed at all — it is reported as a finding, and a
 * finding blocks the release. Version 2.5.0 was blocked this way: build/index.js
 * was one 4.5 MB line worth about 2.1 million tokens.
 *
 * Two things in webpack.config.js keep that from happening — Terser's
 * `max_line_len`, and the loader that breaks the icon JSON into statements. Both
 * are easy to lose by accident: replacing `optimization`, dropping the loader
 * rule, or pulling in a new dependency that inlines a large blob would each put
 * the long line back, and nothing about the build output would say so. The
 * release would simply be rejected again, days later, by email.
 *
 * So the check is part of the build. If it trips, the build fails on the spot
 * with the file name and the line, instead of shipping something that cannot be
 * reviewed.
 *
 * The limit
 * ---------
 * Expressed in characters, because that is what we can measure here. The
 * scanner counts tokens: 4,551,899 characters came to 2,106,157 tokens on the
 * file that was rejected, about 2.16 characters per token, and dense minified
 * code can reach roughly 2. At 2 characters per token a 90,000-token budget is
 * around 180,000 characters, so 100,000 leaves a wide margin and still sits
 * four times above the longest line this build actually produces (~23,000).
 */

const { Compilation } = require('webpack');

const PLUGIN = 'MaxLineLengthPlugin';

/**
 * Longest line in a string, without allocating an array of every line —
 * these assets are megabytes, and split('\n') on all of them is wasteful.
 *
 * @param {string} text
 * @return {{length: number, line: number}} Longest line and its 1-based number.
 */
function longestLine(text) {
	let longest = 0;
	let longestAt = 1;
	let start = 0;
	let line = 1;

	for (;;) {
		const next = text.indexOf('\n', start);
		const length = (-1 === next ? text.length : next) - start;

		if (length > longest) {
			longest = length;
			longestAt = line;
		}

		if (-1 === next) {
			return { length: longest, line: longestAt };
		}

		start = next + 1;
		line += 1;
	}
}

class MaxLineLengthPlugin {
	/**
	 * @param {Object} options
	 * @param {number} options.limit Characters allowed on one line.
	 */
	constructor({ limit = 100000 } = {}) {
		this.limit = limit;
	}

	apply(compiler) {
		compiler.hooks.thisCompilation.tap(PLUGIN, (compilation) => {
			compilation.hooks.processAssets.tap(
				{
					name: PLUGIN,
					// REPORT runs after minification, so what is measured is what
					// is written to disk rather than the pre-Terser source.
					stage: Compilation.PROCESS_ASSETS_STAGE_REPORT,
				},
				(assets) => {
					for (const name of Object.keys(assets)) {
						if (!name.endsWith('.js')) {
							continue;
						}

						const source = compilation.getAsset(name)?.source.source();
						const text = 'string' == typeof source ? source : String(source);
						const { length, line } = longestLine(text);

						if (length > this.limit) {
							compilation.errors.push(
								new Error(
									`${PLUGIN}: ${name} line ${line} is ${length.toLocaleString()} characters, over the ${this.limit.toLocaleString()} character limit.\n` +
										'A line this long is skipped by the plugin review scanner, which blocks the release.\n' +
										'Usually this means either the Terser max_line_len setting or the json-chunks-loader rule\n' +
										'in webpack.config.js was lost, or a new dependency inlines a large data blob.'
								)
							);
						}
					}
				}
			);
		});
	}
}

module.exports = MaxLineLengthPlugin;
module.exports.longestLine = longestLine;
