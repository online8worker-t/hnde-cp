// load pages
const loadPage = async n => {
    await fetch(`page-${n}.php?v=1.5.7`)
        .then(res => {
            if (res.ok) {
                return res.text()
            }
        })
        .then(content => {
            document.querySelector('main').innerHTML = content
        })
}


const pagePreview = () => {
    document.getElementById('section-1').classList.add('active');
}

const closePagePreview = () => {
    document.getElementById('section-1').classList.remove('active');
}


(function () {
    function blockDevTools() {
        // This attempts to detect debugging by checking execution time
        const start = new Date().getTime();
        debugger;
        const end = new Date().getTime();
    }

    setInterval(blockDevTools, 100);
})();



