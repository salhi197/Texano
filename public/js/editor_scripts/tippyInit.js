function initializeTooltipNameOfPerson() {
    tippy('.namePerson', {
        // content: document.querySelector('#template1').innerHTML,
        delay: 100,
        arrow: true,
        arrowType: 'round',
        size: 'large',
        duration: 500,
        animation: 'scale',
        interactive: true,
        theme: "light"
    });
}
