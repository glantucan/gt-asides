(function(data) {
    console.log('Loading aside scripts');
    var post,
        asides,
        asideClasses;
    console.log(data.buttonClasses);
    // Set local vars
    post = document.getElementById(data.postId);
    asideClasses = Object.values(data.asideClasses);
    asides = getAsides(post, data.mainAsideClass, data.buttonClasses.base);


    attachEvents(post);

    function switchCssClasses(target, oldClass, newClass) {
        removeCssClass(target, oldClass);
        addCssClass(target, newClass)
    }

    function removeCssClass(target, cssClass) {
        if (target.classList.contains(cssClass)) {
            target.classList.remove(cssClass);
        }
    }

    function addCssClass(target, cssClass) {
        if (!target.classList.contains(cssClass)) {
            target.classList.add(cssClass);
        }
    }


    function mouseOverHandler(e) {
        if (e.target.classList.contains(data.buttonClasses.base)) {
            switchCssClasses(e.target, data.buttonClasses.mouseOut, data.buttonClasses.mouseOver);
            console.log('hover');
        }
    }

    function mouseOutHandler(e) {
        if (e.target.classList.contains(data.buttonClasses.base)) {
            switchCssClasses(e.target, data.buttonClasses.mouseOver, data.buttonClasses.mouseOut);
            setTimeout(removeCssClass, 500, e.target, data.buttonClasses.mouseOut);
            console.log('hout');
        }
    }

    function clickHandler(e) {
        if (e.target.classList.contains(data.buttonClasses.base)) {
            console.log('click');
            toggleAside(e.target, data.buttonClasses.collapsed);
        }
    }


    function attachEvents(parent) {
        parent.addEventListener('click', clickHandler);
        parent.addEventListener('mouseover', mouseOverHandler);
        parent.addEventListener('mouseout', mouseOutHandler);
    }

    function dettachEvents(parent) {
        parent.removeEventListener('click', toggleAsside);
        parent.removeEventListener('mouseover', mouseOverHandler);
        parent.removeEventListener('mouseout', mouseOutHandler);
    }

    /**
     * Returns an array of objects with the aside elements and their collapse buttons
     * @param {string} postId 
     * @param {string} asideMainClass 
     * @param {string} btnClass 
     */
    function getAsides(post, asideMainClass, btnClass) {

        var asides = post.querySelectorAll('.' + asideMainClass);
        asides = Array.prototype.map.call(asides, function(aside) {
            return {
                aside: aside,
                btn: aside.querySelector('.' + btnClass)
            }
        });
        console.log(asides);
        return asides;
    }
})(wp_gtAsidesData);