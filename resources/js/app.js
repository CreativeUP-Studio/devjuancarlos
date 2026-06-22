// Advanced Monogram Logo Animations - DEVJUANCARLOS
document.addEventListener('DOMContentLoaded', function() {
    
    // ========== INITIAL ENTRANCE ANIMATION ==========
    const pathD = document.querySelector('.logo-path-d');
    const pathJ = document.querySelector('.logo-path-j');
    
    if (pathD && pathJ) {
        // Set initial state for path drawing & opacity
        pathD.style.strokeDashoffset = '150';
        pathJ.style.strokeDashoffset = '110';
        
        // Execute staggered sequence on page load
        setTimeout(() => {
            // 1. Draw outline of 'D'
            pathD.style.transition = 'stroke-dashoffset 1.2s cubic-bezier(0.25, 1, 0.5, 1)';
            pathD.style.strokeDashoffset = '0';
            
            // 2. Draw outline of 'J' (staggered)
            setTimeout(() => {
                pathJ.style.transition = 'stroke-dashoffset 1.0s cubic-bezier(0.25, 1, 0.5, 1)';
                pathJ.style.strokeDashoffset = '0';
            }, 300);
            
            // 3. Clear inline transitions to allow CSS hover rules to take control
            setTimeout(() => {
                pathD.style.transition = '';
                pathJ.style.transition = '';
            }, 2000);
        }, 200);
    }
});
