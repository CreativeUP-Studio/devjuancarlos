<div class="preloader">
    <div class="preloader-panel-left"></div>
    <div class="preloader-panel-right"></div>
    <div class="preloader-bg-pattern"></div>
    
    <div class="preloader-content">
        <div class="preloader-glow"></div>
        <div class="preloader-ring"></div>
        <div class="preloader-logo-container">
            <svg class="preloader-logo" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="insta-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#405de6" />
                        <stop offset="25%" stop-color="#833ab4" />
                        <stop offset="50%" stop-color="#e1306c" />
                        <stop offset="75%" stop-color="#f56040" />
                        <stop offset="100%" stop-color="#fcaf45" />
                    </linearGradient>
                </defs>
                <!-- Path D Base (Dim outline) -->
                <path class="preloader-path-base" d="M 22,26 L 47,26 A 20,20 0 0 1 67,46 A 20,20 0 0 1 47,66 L 22,66" stroke="rgba(255,255,255,0.06)" stroke-width="8.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                <!-- Path J Base (Dim outline) -->
                <path class="preloader-path-base" d="M 77,43 L 77,56 A 20,20 0 0 1 57,76 L 42,76" stroke="rgba(255,255,255,0.06)" stroke-width="8.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                
                <!-- Path D Animated (Draws over outline) -->
                <path class="preloader-path-d" d="M 22,26 L 47,26 A 20,20 0 0 1 67,46 A 20,20 0 0 1 47,66 L 22,66" stroke="url(#insta-grad)" stroke-width="8.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                <!-- Path J Animated (Draws over outline) -->
                <path class="preloader-path-j" d="M 77,43 L 77,56 A 20,20 0 0 1 57,76 L 42,76" stroke="url(#insta-grad)" stroke-width="8.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
            </svg>
        </div>
    </div>
</div>

<script>
    (function() {
        // Prevent scrolling immediately
        document.body.classList.add('preloader-active');
        
        const pathD = document.querySelector('.preloader-path-d');
        const pathJ = document.querySelector('.preloader-path-j');
        const preloader = document.querySelector('.preloader');
        const logoContainer = document.querySelector('.preloader-logo-container');
        
        // Setup initial stroke state
        if (pathD && pathJ) {
            pathD.style.strokeDasharray = '150';
            pathD.style.strokeDashoffset = '150';
            pathJ.style.strokeDasharray = '110';
            pathJ.style.strokeDashoffset = '110';
            
            // Trigger animation frame reflow
            pathD.getBoundingClientRect();
            
            // Draw path D
            pathD.style.transition = 'stroke-dashoffset 0.6s cubic-bezier(0.25, 1, 0.5, 1)';
            pathD.style.strokeDashoffset = '0';
            
            // Draw path J (staggered)
            setTimeout(function() {
                pathJ.style.transition = 'stroke-dashoffset 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
                pathJ.style.strokeDashoffset = '0';
            }, 150);
        }
        
        // Smooth entrance of logo
        if (logoContainer) {
            logoContainer.style.transform = 'scale(0.7) rotate(-5deg)';
            logoContainer.style.opacity = '0';
            logoContainer.getBoundingClientRect();
            
            logoContainer.style.transition = 'transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.4s ease-out';
            logoContainer.style.transform = 'scale(1) rotate(0deg)';
            logoContainer.style.opacity = '1';
            
            // Start float animation
            setTimeout(function() {
                logoContainer.classList.add('floating-active');
            }, 600);
        }
        
        const startTime = Date.now();
        const minDuration = 800; // Snappy 0.8 seconds minimum display
        
        function hidePreloader() {
            const elapsedTime = Date.now() - startTime;
            const remainingTime = Math.max(0, minDuration - elapsedTime);
            
            setTimeout(function() {
                // Remove float animation to let exit transition run cleanly
                if (logoContainer) {
                    logoContainer.classList.remove('floating-active');
                    logoContainer.classList.add('exit-anim');
                }
                
                // Final panels split-slide reveal transition
                setTimeout(function() {
                    if (preloader) {
                        preloader.classList.add('fade-out');
                    }
                    document.body.classList.remove('preloader-active');
                    
                    // Remove preloader from DOM after transition completes
                    setTimeout(function() {
                        if (preloader) preloader.remove();
                    }, 800);
                }, 150); // Snappy split
            }, remainingTime);
        }
        
        if (document.readyState === 'complete') {
            hidePreloader();
        } else {
            window.addEventListener('load', hidePreloader);
            // Fallback in case load takes too long
            setTimeout(hidePreloader, 3000);
        }
    })();
</script>
