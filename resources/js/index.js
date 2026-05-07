const mainImageContainer = document.querySelector('.main-image');
const mainImage = document.getElementById('mainProductImage');

if (mainImageContainer && mainImage) {
    mainImageContainer.addEventListener('mousemove', (e) => {
        const { left, top, width, height } = mainImageContainer.getBoundingClientRect();
        const x = ((e.clientX - left) / width) * 100;
        const y = ((e.clientY - top) / height) * 100;

        mainImage.style.transformOrigin = `${x}% ${y}%`;
        mainImage.style.transform = "scale(2.5)";
    });

    mainImageContainer.addEventListener('mouseleave', () => {
        mainImage.style.transform = "scale(1)";
        mainImage.style.transformOrigin = "center center";
    });
}

// Make changeImage global for the onclick handlers in Blade
window.changeImage = function(el) {
    if (mainImage) {
        mainImage.src = el.src;
    }
};
