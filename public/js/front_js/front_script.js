$(document).on("ready", function() {
    // Sorting listing ajax
    $("#sort").on("change", function() {
        var sort = $(this).val();
        var fabric = get_filter("fabric");
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "post",
            data: { fabric: fabric, sort: sort, url: url },
            success: function(data) {
                $(".filter_products").html(data);
            }
        });
    });

    $(".fabric").on("click", function() {
        var fabric = get_filter(this);
        var sort = $("#sort option:selected").text();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "post",
            data: { fabric: fabric, sort: sort, url: url },
            success: function(data) {
                $(".filter_products").html(data);
            }
        });
    });

    $(".sleeve").on("click", function() {
        var sleeve = get_filter(this);
        var sort = $("#sort option:selected").text();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "post",
            data: { sleeve: sleeve, sort: sort, url: url },
            success: function(data) {
                $(".filter_products").html(data);
            }
        });
    });

    $(".pattern").on("click", function() {
        var pattern = get_filter(this);
        var sort = $("#sort option:selected").text();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "post",
            data: { pattern: pattern, sort: sort, url: url },
            success: function(data) {
                $(".filter_products").html(data);
            }
        });
    });

    $(".fit").on("click", function() {
        var fit = get_filter(this);
        var sort = $("#sort option:selected").text();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "post",
            data: { fit: fit, sort: sort, url: url },
            success: function(data) {
                $(".filter_products").html(data);
            }
        });
    });

    $(".occasion").on("click", function() {
        var occasion = get_filter(this);
        var sort = $("#sort option:selected").text();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "post",
            data: { occasion: occasion, sort: sort, url: url },
            success: function(data) {
                $(".filter_products").html(data);
            }
        });
    });

    function get_filter(class_name) {
        var filter = [];
        $("." + class_name + ":checked").each(function() {
            filter.push($(this).val());
        });
        return filter;
    }

    $("#getPrice").on("change", function() {
        var size = $(this).val();
        var product_id = $(this).attr("product-id");
        if (size == "") {
            alert("Please select size");
            return false;
        }

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });

        $.ajax({
            url: "/get-product-price",
            data: { size: size, product_id: product_id },
            type: "post",
            success: function(resp) {
                // alert(resp["product_price"]);
                // return false;
                if (resp["discounted_price"] > 0) {
                    var money = new Number(
                        resp["product_price"]
                    ).toLocaleString("id-ID");
                    var moneyDisc = new Number(
                        resp["discounted_price"]
                    ).toLocaleString("id-ID");
                    $(".getAttrPrice").html(
                        "<del>Rp. " + money + "</del>" + "  Rp. " + moneyDisc
                    );
                } else {
                    var money = new Number(
                        resp["product_price"]
                    ).toLocaleString("id-ID");
                    $(".getAttrPrice").html("Rp. " + money);
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });
});
