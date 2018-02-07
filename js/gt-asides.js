(function(data) {
    console.log('Loading aside scripts');
    var post,
        asides,
        asideClasses;

    // Set local vars
    post = document.getElementById(data.postId);
    asideClasses = Object.values(data.asideClasses);
    asides = getAsides(post, data.mainAsideClass, data.buttonClass);


    attachEvents(post);


    function mouseOverHandler(e) {
        if (e.target.classList.contains(data.buttonClass)) {
            console.log('hover');
        }
    }

    function clickHandler(e) {
        if (e.target.classList.contains(data.buttonClass)) {
            console.log('click');
        }
    }


    function attachEvents(parent) {
        parent.addEventListener('click', clickHandler);
        parent.addEventListener('mouseover', mouseOverHandler);
    }

    function dettachEvents(parent) {
        parent.removeEventListener('click', toggleAsside);
        parent.removeEventListener('mouseover', showAsideTitle);
    }

    /**
     * Returns an array of objects with the aside elements and their collapse buttons
     * @param {string} postId 
     * @param {string} asideMainClass 
     * @param {string} btnClass 
     */
    function getAsides(postId, asideMainClass, btnClass) {

        var asides = document.getElementById(data.postId)
            .querySelectorAll('.' + asideMainClass);
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