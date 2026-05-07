
        // Image zoom on hover
        const zoomContainer = document.getElementById('productZoomContainer');
        const mainImg = document.getElementById('productMainImg');

        if (zoomContainer && mainImg) {
            zoomContainer.addEventListener('mousemove', (e) => {
                const { left, top, width, height } = zoomContainer.getBoundingClientRect();
                const x = ((e.clientX - left) / width) * 100;
                const y = ((e.clientY - top) / height) * 100;
                mainImg.style.transformOrigin = `${x}% ${y}%`;
                mainImg.style.transform = 'scale(2.5)';
            });

            zoomContainer.addEventListener('mouseleave', () => {
                mainImg.style.transform = 'scale(1)';
                mainImg.style.transformOrigin = 'center center';
            });
        }

        // Switch thumbnail image
        function switchImage(el) {
            mainImg.src = el.src;
            document.querySelectorAll('.product-thumbs img').forEach(img => img.classList.remove('active'));
            el.classList.add('active');
        }

        // Size selector
        function selectSize(el) {
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
            el.classList.add('active');
        }

        // Color selector
        function selectColor(el) {
            document.querySelectorAll('.color-swatch').forEach(swatch => swatch.classList.remove('active'));
            el.classList.add('active');
        }
