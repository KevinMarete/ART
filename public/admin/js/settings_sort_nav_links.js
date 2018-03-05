
//script to sort settings_nav links alphabetically
var mylist = $('#list');
var listitems = mylist.children('li').get();

listitems.sort(function (a, b) {
    return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
})

mylist.empty().append(listitems)