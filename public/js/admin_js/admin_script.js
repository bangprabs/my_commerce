$(document).ready(function() {
    $("#current_pwd").keyup(function() {
        var current_pwd = $("#current_pwd").val();
        // alert(current_pwd);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });
        $.ajax({
            type: "post",
            url: "check-current-pwd",
            data: { current_pwd: current_pwd },
            success: function(resp) {
                if (resp == "false") {
                    $("#chkCurrentPwd").html(
                        "<font color=red>Current Password is Incorrect</font>"
                    );
                } else if (resp == "true") {
                    $("#chkCurrentPwd").html(
                        "<font color=green>Current Password is Correct</font>"
                    );
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Update Section Status
    $(document).on("click", ".updateSectionStatus", function() {
        var status = $(this).text();
        var section_id = $(this).attr("section_id");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });
        $.ajax({
            type: "post",
            url: "/admin/update-section-status",
            data: { status: status, section_id: section_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#section-" + section_id)
                        .removeClass("btn btn-primary")
                        .addClass("btn btn-danger")
                        .html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#section-" + section_id)
                        .removeClass("btn btn-danger")
                        .addClass("btn btn-primary")
                        .html("Active");
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Update Category Status
    $(document).on("click", ".updateCategoryStatus", function() {
        var status = $(this).text();
        var category_id = $(this).attr("category_id");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });
        $.ajax({
            type: "post",
            url: "/admin/update-category-status",
            data: { status: status, category_id: category_id },
            success: function(resp) {
                // alert(resp["status"]);
                // alert(resp["section_id"]);
                if (resp["status"] == 0) {
                    $("#category-" + category_id)
                        .removeClass("btn btn-primary")
                        .addClass("btn btn-danger")
                        .html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#category-" + category_id)
                        .removeClass("btn btn-danger")
                        .addClass("btn btn-primary")
                        .html("Active");
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Append Category Level
    $("#section_id").change(function() {
        var section_id = $(this).val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });
        $.ajax({
            type: "post",
            url: "/admin/append-categories-level",
            data: { section_id: section_id },
            success: function(resp) {
                $("#appendCategoriesLevel").html(resp);
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Confrim Delete With Sweet Alert
    $(document).on("click", ".confirmDelete", function() {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.isConfirmed) {
                window.location.href =
                    "/admin/delete-" + record + "/" + recordid;
            }
        });
    });

    // Update Products Status
    $(document).on("click", ".updateProductsStatus", function() {
        var status = $(this).text();
        var product_id = $(this).attr("product_id");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });
        $.ajax({
            type: "post",
            url: "/admin/update-product-status",
            data: { status: status, product_id: product_id },
            success: function(resp) {
                // alert(resp["status"]);
                // alert(resp["section_id"]);
                if (resp["status"] == 0) {
                    $("#product-" + product_id)
                        .removeClass("btn btn-primary")
                        .addClass("btn btn-danger")
                        .html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#product-" + product_id)
                        .removeClass("btn btn-danger")
                        .addClass("btn btn-primary")
                        .html("Active");
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Product Attributes Add/Remove Script
    var maxField = 10; //Input fields increment limitation
    var addButton = $(".add_button"); //Add button selector
    var wrapper = $(".field_wrapper"); //Input field wrapper
    var fieldHTML =
        '<div class="mt-3 col-auto input-group-append p-0"><input id="size" name="size[]" name="size[]" required placeholder="Size" type="text" type="text" class="form-control mr-2 "><input id="sku" name="sku[]" name="sku[]" required placeholder="SKU" type="text" type="text" class="form-control mr-2 "><input id="price" name="price[]" name="price[]" required placeholder="Price" type="text" type="number" class="form-control mr-2 "><input id="stock" name="stock[]" name="stock[]" required placeholder="Stock" type="text" type="numer" class="form-control mr-2"><button class="remove_button btn btn-danger rounded"><a href="javascript:void(0);" title="Add field"><i class="fas fa-minus" style="color: #fff"></i></a></button></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function() {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on("click", ".remove_button", function(e) {
        e.preventDefault();
        $(this)
            .parent("div")
            .remove(); //Remove field html
        x--; //Decrement field counter
    });

    // Update Attributes Status
    $(document).on("click", ".updateAttributesStatus", function() {
        var status = $(this).text();
        var attribute_id = $(this).attr("attribute_id");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });
        $.ajax({
            type: "post",
            url: "/admin/update-attribute-status",
            data: { status: status, attribute_id: attribute_id },
            success: function(resp) {
                // alert(resp["status"]);
                // alert(resp["section_id"]);
                if (resp["status"] == 0) {
                    $("#attribute-" + attribute_id)
                        .removeClass("btn btn-primary")
                        .addClass("btn btn-danger")
                        .html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#attribute-" + attribute_id)
                        .removeClass("btn btn-danger")
                        .addClass("btn btn-primary")
                        .html("Active");
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Update Images Status
    $(document).on("click", ".updateImageStatus", function() {
        var status = $(this).text();
        var image_id = $(this).attr("image_id");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });
        $.ajax({
            type: "post",
            url: "/admin/update-images-status",
            data: { status: status, image_id: image_id },
            success: function(resp) {
                // alert(resp["status"]);
                // alert(resp["section_id"]);
                if (resp["status"] == 0) {
                    $("#image-" + image_id)
                        .removeClass("btn btn-primary")
                        .addClass("btn btn-danger")
                        .html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#image-" + image_id)
                        .removeClass("btn btn-danger")
                        .addClass("btn btn-primary")
                        .html("Active");
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Update Brands Status
    $(document).on("click", ".updateBrandStatus", function() {
        var status = $(this).text();
        var brand_id = $(this).attr("brand_id");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });
        $.ajax({
            type: "post",
            url: "/admin/update-brands-status",
            data: { status: status, brand_id: brand_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#brand-" + brand_id)
                        .removeClass("btn btn-primary")
                        .addClass("btn btn-danger")
                        .html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#brand-" + brand_id)
                        .removeClass("btn btn-danger")
                        .addClass("btn btn-primary")
                        .html("Active");
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Update Banner Status
    $(document).on("click", ".updateBannerStatus", function() {
        var status = $(this).text();
        var banner_id = $(this).attr("banner_id");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });
        $.ajax({
            type: "post",
            url: "/admin/update-banner-status",
            data: { status: status, banner_id: banner_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#banner-" + banner_id)
                        .removeClass("btn btn-primary")
                        .addClass("btn btn-danger")
                        .html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#banner-" + banner_id)
                        .removeClass("btn btn-danger")
                        .addClass("btn btn-primary")
                        .html("Active");
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Update Coupon Status
    $(document).on("click", ".updateCouponStatus", function() {
        var status = $(this).text();
        var coupon_id = $(this).attr("coupon_id");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery(`meta[name="csrf-token"]`).attr(
                    "content"
                )
            }
        });
        $.ajax({
            type: "post",
            url: "/admin/update-coupon-status",
            data: { status: status, coupon_id: coupon_id },
            success: function(resp) {
                if (resp["status"] == 0) {
                    $("#coupon-" + coupon_id)
                        .removeClass("btn btn-primary")
                        .addClass("btn btn-danger")
                        .html("Inactive");
                } else if (resp["status"] == 1) {
                    $("#coupon-" + coupon_id)
                        .removeClass("btn btn-danger")
                        .addClass("btn btn-primary")
                        .html("Active");
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    //show hide coupon code field for manual/automatic trigger
    $("#manualCoupon").click(function() {
        $("#couponField").show();
    });

    $("#automaticCoupon").click(function() {
        $("#couponField").hide();
    });
});
