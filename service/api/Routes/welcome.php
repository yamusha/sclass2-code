<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master PHP Framework REST API ด้วย PHP OOP</title>
    <link rel="shortcut icon" type="image/x-icon" href="logo.ico">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .page{
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .text-center{
            text-align: center;
        }

        .title {
            font-size: 84px;
            margin-bottom: 30px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
</head>    
<body>
    <div class="page" v-cloak id="app">
        <div class="text-center">
            <p class="title" v-html="title"></p>
            <p class="links">
                <a v-for="link in links" :href="link.link" target="_blank">{{link.name}}</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script> 
    <script>
        new Vue({
            el: "#app",
            data () {
                return {
                   title: "Master PHP Framework <br> REST API (PHP OOP)",
                   links: []
                }
            },
            mounted () {
                this.getData()
            },
            methods: {
                getData () {
                    fetch('../api/home')
                    .then(response => response.json())
                    .then(data => {
                        this.links = data.response
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            }
        })
    </script>
</body>
</html>
