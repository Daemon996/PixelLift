document.addEventListener('DOMContentLoaded', function() {
    let images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(function(img) {
        let lowQualitySrc = img.src;
        let mediumQualitySrc = lowQualitySrc.replace('low', 'medium');
        let highQualitySrc = lowQualitySrc.replace('low', 'full');
        
        // Start with low quality, then upgrade to medium and high
        setTimeout(function() {
            img.src = mediumQualitySrc;
            setTimeout(function() {
                img.src = highQualitySrc;
            }, 1000); // Change to high quality after a brief delay
        }, 500); // Change to medium quality after a brief delay
    });
});