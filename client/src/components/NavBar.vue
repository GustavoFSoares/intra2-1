<template>
    <div id="navbar">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <router-link class="navbar-brand" to="/">Home</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <!-- <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li> -->
                    <li class="nav-item" v-for="(screen, index) in screens" :key="index">
                        <a v-if="screen.externalLink" class="nav-link" :href="screen.link">{{ screen.name }}</a>
                        <router-link v-else class="nav-link" :to="screen.link">{{ screen.name }}</router-link>
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                    </li> -->
                </ul>

                <div class="navbar-nav">
                    <div class="nav-item">
                        <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"@click= > -->
                        <a class="nav-link" :href="login.link">
                            {{ login.name }}
                            <i class="fa fa-user" style="font-size:20px"></i>
                        </a>
                    </div>
                </div>
                
            </div>
        </nav>

    </div>
</template>

<script>
export default {
    data(){
        return {
            "message": "",
            "screens": [
                {name: "Convênios", link:"http://gamp-web/?tela=convenio", externalLink: true },
                {name: "Ramais", link:"/ramais", externalLink: false },
                {name: "Arquivos", link:"http://gamp-web/?tela=arquivos", externalLink: true },
                {name: "POPS", link:"http://gamp-web/?tela=pops", externalLink: true },
                {name: "Institucional", link:"http://gamp-web/?tela=institucional", externalLink: true },
                {name: "Comissões", link:"http://gamp-web/?tela=comissoes", externalLink: true },
            ],
            "login": {name: "Login", link:"http://gamp-web/?tela=Login" },
        }
    },
    methods: { }
}
</script>

<style scoped>
    #navbar {
        width: 100%;
        height: 100%;
        display: block;
    }
</style>


