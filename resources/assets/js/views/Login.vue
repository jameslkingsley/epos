<template>
    <div class="container">
        <md-toolbar class="md-dense">
            <nav-till />

            <h2 class="md-title" style="flex: 1">
                Login
            </h2>
        </md-toolbar>

        <div class="page-content">
            <div class="main-content">
                <md-whiteframe class="p-a-3">
                    <md-input-container>
                        <label>Email Address</label>
                        <md-input type="text"></md-input>
                    </md-input-container>

                    <md-input-container>
                        <label>Password</label>
                        <md-input type="password"></md-input>
                    </md-input-container>

                    <md-button class="md-raised md-primary pull-right m-a-0">Login</md-button>
                </md-whiteframe>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        //
    }
</script>
