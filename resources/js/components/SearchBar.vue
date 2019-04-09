<template>
    <div>
        <div class="row mt-5 mb-5">
            <div class="col d-flex justify-content-center align-content-center">
                <input v-model="search" class="pl-2 w-50 mr-3" type="text" placeholder="Search">
                <button @click="filter" class="btn btn-outline-primary">Search</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchBar",
        data () {
            return {
                search: ''
            }
        },
        methods: {
            filter() {
                let self = this;
                if (this.search !== '')
                {
                    axios.post('/searches', {
                        search: self.search
                    })
                        .then(response => {
                            window.location = '/' + self.search;
                        })
                        .catch(error => {
                            console.log(error.data)
                        });
                }
                else
                    window.location = '/';
            }
        },
        mounted() {

        }
    }
</script>

<style scoped lang="sass">
input, button
    font-size: 18px
</style>