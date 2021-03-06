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
                if (resp["discount"] > 0) {
                    var money = new Number(
                        resp["product_price"]
                    ).toLocaleString("id-ID");
                    var moneyDisc = new Number(
                        resp["final_price"]
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

    $(document).on("click", ".btnItemUpdate", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });

        if ($(this).hasClass("qtyMinus")) {
            var quantity = $(this)
                .prev()
                .val();
            if (quantity <= 1) {
                alert("Item quantity must be at least 1 or greater");
                return false;
            } else {
                new_qty = parseInt(quantity) - 1;
            }
        }
        if ($(this).hasClass("qtyPlus")) {
            var quantity = $(this)
                .prev()
                .prev()
                .val();
            new_qty = parseInt(quantity) + 1;
        }
        // alert(new_qty);
        var cartId = $(this).data("cartid");
        // alert(cartId);
        $.ajax({
            data: { cartid: cartId, qty: new_qty },
            url: "/update-cart-item-qty",
            type: "post",
            success: function(resp) {
                if (resp.status == false) {
                    alert(resp.message);
                }
                $(".totalCartItems").html(resp.totalCartItems);
                $("#AppendCartItems").html(resp.view);
            },
            error: function() {
                alert("Error");
            }
        });
    });

    //Delete cart item
    $(document).on("click", ".btnItemDelete", function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });

        var cartId = $(this).data("cartid");
        var result = confirm("Want To Delete this Item ? ");
        if (result) {
            $.ajax({
                data: { cartid: cartId },
                url: "/delete-cart-item",
                type: "post",
                success: function(resp) {
                    $("#AppendCartItems").html(resp.view);
                    $(".totalCartItems").html(resp.totalCartItems);
                },
                error: function() {
                    alert("Error");
                }
            });
        }
    });

    $("#registerForm").validate({
        rules: {
            name: "required",
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 12,
                digits: true
            },
            password: {
                required: true,
                minlength: 6
            },
            email: {
                required: true,
                email: true,
                remote: "check-email"
            },
            agree: "required"
        },
        messages: {
            name: "Please enter your name",
            mobile: {
                required: "Please enter a mobile number",
                minlength:
                    "Your mobile number must consist of at least 10 digits",
                maxlength:
                    "Your mobile number must consist of at least 10 digits",
                digits: "Please enter your valid Mobile Number"
            },
            email: {
                required: "Please enter your email",
                email: "Please enter valid email",
                remote: "Email already Exist !"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            }
        }
    });

    $("#loginForm").validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            email: {
                required: true,
                email: true
                // remote: "check-email"
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter valid email"
            },
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 5 characters long"
            }
        }
    });

    $("#forgotPasswordForm").validate({
        rules: {
            email: {
                required: true,
                email: true
                // remote: "check-email"
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter valid email"
            }
        }
    });

    $("#accountForm").validate({
        rules: {
            name: {
                required: true,
                lettersonly: true
            },
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 12,
                digits: true
            }
        },
        messages: {
            name: {
                required: "Please enter your Name",
                lettersonly: "Please enter valide Name"
            },
            mobile: {
                required: "Please enter a mobile number",
                minlength:
                    "Your mobile number must consist of at least 10 digits",
                maxlength:
                    "Your mobile number must consist of at least 10 digits",
                digits: "Please enter your valid Mobile Number"
            }
        }
    });

    //Check current user password
    $("#current_pwd").keyup(function(e) {
        var current_pwd = $(this).val();
        $.ajax({
            type: "post",
            url: "/check-user-password",
            data: { current_pwd: current_pwd },
            success: function(resp) {
                // alert(resp);
                if (resp == "false") {
                    $("#chkPwd").html(
                        "<font color='red'><b>Current Password is Incorrect</b></font>"
                    );
                } else if (resp == "true") {
                    $("#chkPwd").html(
                        "<font color='green'><b>Current Password is Correct</b></font>"
                    );
                }
            },
            error: function(params) {
                alert("Error");
            }
        });
    });

    $("#passwordForm").validate({
        rules: {
            current_pwd: {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            new_password: {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            confirm_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
                equalTo: "#new_password"
            }
        },
        messages: {
            current_pwd: {
                required: "Please enter your Current Password",
                minlength: "Your password must be at least 5 characters long"
            },
            new_password: {
                required: "Please enter your New Password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please enter your Confirm Password",
                minlength: "Your password must be at least 5 characters long"
            }
        }
    });

    // Apply coupon code
    $("#applyCoupon").on("submit", function() {
        var user = $(this).attr("user");
        if (user == 1) {
            // do nothing
        } else {
            alert("Please login first, to apply coupon");
            return false;
        }
        var code = $("#code").val();
        $.ajax({
            type: "post",
            data: { code: code },
            url: "/apply-coupon",
            success: function(resp) {
                if (resp.message != "") {
                    alert(resp.message);
                }
                $("#AppendCartItems").html(resp.view);
                $(".totalCartItems").html(resp.totalCartItems);
             },
            error: function() {
                alert("Error");
            }
        });
    });
});
