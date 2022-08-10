(function() {
    document.querySelectorAll('.toast').forEach(el => {
        var bsAlert = new bootstrap.Toast(el);//inizialize it
        bsAlert.show();//show it
    })
})();