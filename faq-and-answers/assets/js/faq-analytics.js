/**
 * FAQ Analytics screen — the chart's hover readout.
 *
 * The two area paths are drawn in PHP, straight into the SVG, so the chart is
 * complete before this file runs and stays complete if it never does. All that
 * happens here is turning a mouse position into a day and showing its numbers.
 *
 * No charting library: the whole plot is one polyline per series, which is
 * less code than configuring one would be and leaves nothing to load.
 */
(function () {
	'use strict';

	/**
	 * "Clear data" throws away every record, so it asks first. Wired here
	 * rather than as an onclick attribute, so a translated message containing a
	 * quote cannot break the markup.
	 */
	var guardDestructiveLinks = function () {
		document.addEventListener('click', function (event) {
			if (!event.target || !event.target.closest) {
				return;
			}

			var link = event.target.closest('[data-afaq-confirm]');

			if (link && !window.confirm(link.getAttribute('data-afaq-confirm'))) {
				event.preventDefault();
			}
		});
	};

	var boot = function () {
		guardDestructiveLinks();

		var root = document.getElementById('afaqAnChart');

		if (!root || !window.afaqAnalyticsChart) {
			return;
		}

		var data = window.afaqAnalyticsChart;
		var days = Array.isArray(data.days) ? data.days : [];

		if (days.length === 0) {
			return;
		}

		var hit = root.querySelector('.afaqAnHit');
		var plot = root.querySelector('.afaqAnPlot');

		if (!hit || !plot) {
			return;
		}

		var cursor = document.createElement('div');
		cursor.className = 'afaqAnCursor';
		cursor.hidden = true;

		var tip = document.createElement('div');
		tip.className = 'afaqAnTip';
		tip.hidden = true;

		plot.appendChild(cursor);
		root.appendChild(tip);

		var escapeHtml = function (value) {
			return String(value).replace(/[&<>"']/g, function (char) {
				return {
					'&': '&amp;',
					'<': '&lt;',
					'>': '&gt;',
					'"': '&quot;',
					"'": '&#39;'
				}[char];
			});
		};

		var show = function (index, rect) {
			var day = days[index];

			if (!day) {
				return;
			}

			// Same placement render.php used for the path vertices — first day
			// on the left edge, last on the right — so the cursor lands on the
			// point it is reading out.
			var span = days.length > 1 ? rect.width / (days.length - 1) : 0;
			var x = days.length > 1 ? span * index : rect.width / 2;

			cursor.style.left = x + 'px';
			cursor.hidden = false;

			tip.innerHTML =
				'<strong>' + escapeHtml(day.label) + '</strong>' +
				'<div class="afaqAnTipRow tone-blue"><em></em>' + escapeHtml(data.seriesOne) + '<b>' + escapeHtml(day.one) + '</b></div>' +
				'<div class="afaqAnTipRow tone-orange"><em></em>' + escapeHtml(data.seriesTwo) + '<b>' + escapeHtml(day.two) + '</b></div>';

			tip.hidden = false;

			// Keep the box inside the panel: past either edge it would be cut
			// off by the panel's own border.
			var half = tip.offsetWidth / 2;
			var left = x + plot.offsetLeft;

			left = Math.max(half + 4, Math.min(left, root.clientWidth - half - 4));

			tip.style.left = left + 'px';
			tip.style.top = plot.offsetTop - 10 + 'px';
		};

		var hide = function () {
			cursor.hidden = true;
			tip.hidden = true;
		};

		var locate = function (clientX) {
			var rect = hit.getBoundingClientRect();

			if (rect.width <= 0) {
				return;
			}

			var ratio = (clientX - rect.left) / rect.width;
			// Nearest point rather than the slice it fell in: the points are on
			// the edges, so the halves at either end belong to one point each.
			var index = Math.round(ratio * (days.length - 1));

			show(Math.max(0, Math.min(days.length - 1, index)), rect);
		};

		hit.addEventListener('mousemove', function (event) {
			locate(event.clientX);
		});

		hit.addEventListener('mouseleave', hide);

		// A touch gets the same readout, and tapping away clears it.
		hit.addEventListener('touchstart', function (event) {
			if (event.touches && event.touches.length) {
				locate(event.touches[0].clientX);
			}
		}, { passive: true });

		hit.addEventListener('touchend', hide);

		window.addEventListener('resize', hide);
	};

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
