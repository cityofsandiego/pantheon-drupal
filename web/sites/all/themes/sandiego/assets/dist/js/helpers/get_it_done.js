// For a survey that pops up about 1% of the time. Meant for the get-it-done page.
(function () {
    setTimeout(function () {
        var d = document, t = 'script', f = d.getElementsByTagName(t)[0], s = d.createElement(t);
        s.type = 'text/java' + t;
        s.async = true;
        s.src = '//d2rnkf2kqy5m6h.cloudfront.net/vxc/cEuvggQuTDSTmdANMXT-Yw/surveys.js?' + (new Date) / 1;
        f.parentNode.insertBefore(s, f);
    }, 1);
})();
