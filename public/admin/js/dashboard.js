var colors = [
				['#d02518', '#fff'], ['#FCE6A4', '#EFB917'], ['#BEE3F7', '#45AEEA'], ['#F8F9B6', '#D2D558'], ['#F4BCBF', '#D43A43']
			],
			circles = [];

		for (var i = 1; i <= 5; i++) {
			var child = document.getElementById('circles-' + i),
				percentage = 31.42 + (i * 9.84),
				
				circle = Circles.create({
					id:         child.id,
					value:      percentage,
					radius:     getWidth(),
					width:      5,
					colors:     colors[i - 1]
				});

			circles.push(circle);
		}

		window.onresize = function(e) {
			for (var i = 0; i < circles.length; i++) {
				circles[i].updateRadius(getWidth());
			}
		};

		function getWidth() {
            return $('.pieprogress').width()/2;
			return window.innerWidth / 10;
		}