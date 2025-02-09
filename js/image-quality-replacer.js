document.addEventListener('DOMContentLoaded', function() {
    let images = document.querySelectorAll('img.iqr-lazy');

    images.forEach(img => {
        let srcset = img.dataset.srcset;
        let originalSrc = img.dataset.original;

        if (!srcset || !originalSrc) return;

        let sources = srcset.split(',').map(src => {
            let parts = src.trim().split(' ');
            return { url: parts[0], size: parseInt(parts[1], 10) || 0 };
        });

        // Sort sources from lowest to highest resolution
        sources.sort((a, b) => a.size - b.size);

        // Only use sizes that are less than or equal to the original selected size
        sources = sources.filter(source => source.url.includes(originalSrc) || source.size <= img.width);

        let index = 0;

        function upgradeImage() {
            if (index < sources.length) {
                img.src = sources[index].url;
                index++;
                setTimeout(upgradeImage, 1000); // Delay before upgrading to next quality level
            }
        }

        upgradeImage(); // Start progressive loading
    });
});