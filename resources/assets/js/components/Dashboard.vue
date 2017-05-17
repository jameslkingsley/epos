<template>
    <div class="dashboard">
        <categories>
            <div class="logo">
                <a :href="app.url" class="simple-text">
                    <clock></clock>
                </a>
            </div>
        </categories>

        <div class="main-panel">
            <nav class="navbar navbar-default" style="width: calc(100% - 25vw)">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Dashboard</a>
                    </div>
                </div>
            </nav>

            <div class="content" style="width: calc(100% - 25vw)">
                <div class="container-fluid p-a-0">
                    <products></products>
                </div>
            </div>

            <div class="sidebar sidebar-right" data-background-color="white" data-active-color="danger">
                <div class="sidebar-wrapper">
                    <basket></basket>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                app: window.epos.app
            }
        }
    }
</script>
