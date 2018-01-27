<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="http://mozilla.github.io/mofo-bootstrap/dest/css/mofo-bootstrap.css">
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <title>Vk test</title>
</head>
<body>
<div id="app" class="container">
    <div class="row">
        <div class="col-sm-8"></div>
        <div class="col-sm-4">Logged as: </div>
    </div>

    <div class="row">
        <div class="col">

        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            #
        </div>
        <div class="col-sm">
            Order title
        </div>
        <div class="col-sm">
            Customer
        </div>
        <div class="col-sm">
            Action
        </div>
    </div>
    <template v-for="order in orders">
        <div class="row">
            <div class="col-sm">
                {{order.id}}
            </div>
            <div class="col-sm">
                {{order.title}}
            </div>
            <div class="col-sm">
                {{order.customer}}
            </div>
            <div class="col-sm">
                {{order.customer}}
            </div>
        </div>
    </template>

    <modal></modal>
    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target=".modal">
        Select a role
    </button>
</div>



<template id="bs-modal">
<div id="role-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose a role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Choose a role: customer or contractor</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Customer</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Contractor</button>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    Vue.component('modal', {
        template: '#bs-modal',
        data: function () {
            console.log("### DATA");
        }
    });

    var app = new Vue({
        el: '#app',
        data: {
            orders: null
        },
        created: function () {
            this.fetchData();
            this.showModal();
        },
        methods: {
            fetchData: function () {
                var xhr = new XMLHttpRequest();
                var self = this;
                xhr.open('GET', '/vktest/orders.php');
                xhr.onload = function () {
                    self.orders = JSON.parse(xhr.responseText);
                    console.log(self.orders);
                };
                xhr.send();
            },
            showModal: function () {
                //$('#role-modal').show();
                //console.log("### DATA");
            }
        }
    })
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>