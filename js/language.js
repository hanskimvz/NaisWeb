_selected_language = "Korean";
var lang = new Array();
$.getJSON("/inc/lang.json", function(language) {
    // console.log(language);
    language.forEach(function(item){
        // console.log(item);
        // lang[item.key.toLowerCase()] = item[_selected_language];
        lang[item.key] = item[_selected_language];
    });
    $("span").each(function(idx, item){
        x = $(this).text().replace(" ","").toLowerCase();
        $(this).text(lang[x]);
        // x = item;
        // console.log(x);
    });
});