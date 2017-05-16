<template>
    <div class="dashboard">
        <categories>
            <div class="logo">
                <a :href="app.url" class="simple-text">
                    {{ app.name }}
                </a>
            </div>
        </categories>

        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Dashboard</a>
                    </div>
                </div>
            </nav>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8 col-sm-12 p-x-0">
                            <products></products>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <basket></basket>
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
