$(".cs ").bind("click", function () {
    var table1 = $('#detail_editable_1').DataTable();
    console.log(table1);
    console.log(table1.data());
    console.log(table1.rows().data());
});