(function(data) {
    'use strict';
    console.log('Loading aside scripts');
    var post,
        asides,
        asideClasses;
    console.log(data);
    // Set local vars
    post = document.getElementById(data.postId);
    asideClasses = Object.values(data.asideClasses);
    asides = getAsides(post, data.mainAsideClass, data.buttonClasses.class);


    attachEvents(post);

    function toggleAside(aside, collapseClass) {
        console.log(collapseClass);
        aside.classList.toggle(collapseClass);
    }

    function switchCssClasses(target, oldClass, newClass) {
        removeCssClass(target, oldClass);
        addCssClass(target, newClass)
    }

    function removeCssClass(target, cssClass) {
        if (target.classList.contains(cssClass)) {
            target.classList.remove(cssClass);
        } else {
            console.warn("target doesn't have a class named", cssClass);
        }
    }

    function addCssClass(target, cssClass) {
        if (!target.classList.contains(cssClass)) {
            target.classList.add(cssClass);
        } else {
            console.warn("target already have a class named", cssClass);
        }
    }


    function mouseOverHandler(e) {
        if (e.target.classList.contains(data.buttonClasses.class)) {
            switchCssClasses(e.target, data.buttonClasses.mouseOut,
                data.buttonClasses.mouseOver);
        }
    }

    function mouseOutHandler(e) {
        if (e.target.classList.contains(data.buttonClasses.class)) {
            switchCssClasses(e.target, data.buttonClasses.mouseOver,
                data.buttonClasses.mouseOut);
            setTimeout(removeCssClass, 500, e.target, data.buttonClasses.mouseOut);
        }
    }

    function clickHandler(e) {
        if (e.target.classList.contains(data.buttonClasses.class)) {
            // Get the parent aside of the target button:
            var targetAside = asides.find(function(aside) {
                return  aside.firstBtn == e.target || 
                        aside.secondBtn == e.target;
            });
            console.log(targetAside);
            toggleAside(targetAside.aside, data.collapseClass);
        }
    }


    function attachEvents(parent) {
        parent.addEventListener('click', clickHandler);
        parent.addEventListener('mouseover', mouseOverHandler);
        parent.addEventListener('mouseout', mouseOutHandler);
    }

    function dettachEvents(parent) {
        parent.removeEventListener('click', clickHandler);
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
        console.log(asides);
        asides = Array.prototype.map.call(asides, function(aside) {
            // get the two toggle buttons
            var buttons = aside.querySelectorAll('.' + btnClass);
            return {
                aside: aside,
                firstBtn: buttons[0],
                secondBtn: buttons[1]
            }
        });
        console.log(asides);
        return asides;
    }
})(wp_gtAsidesData);