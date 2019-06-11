<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-5 offset">
                <form @submit.prevent="addFuel">
                    <div class="form-group">
                        <label for="tank">Enter the volume of product left in the Tank</label>
                        <input type="number" v-model="fuel.tank" class="form-control" placeholder=""  required>
                    </div>
                    <div class="form-group">
                        <label for="dispenser_1">Enter the volume of product sold by dispenser 1</label>
                        <input type="number" v-model="fuel.dispenser_1" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="dispenser_2">Enter the volume of product sold by dispenser 2</label>
                        <input type="number" v-model="fuel.dispenser_2" class="form-control" placeholder="" required>
                    </div>
                    <button class="btn bg-dark text-white" type="submit">Save</button>
                </form>
            </div>
        </div>
        <table class="table table-striped" >
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Date</th>
                    <th>Tank</th>
                    <th>Dispenser 1</th>
                    <th>Dispenser 2</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr v-for="(fuel, index) in fuels" v-bind:key="fuel.id">
                    <td>{{ index+1 }}</td>
                    <td>20/3/2019{{  }}</td>
                    <td>
                     {{ fuel.tank }} <span>L</span>
                    </td>
                    <td>
                       {{ fuel.dispenser_1 }} <span>L</span>
                    </td>
                    <td>
                       {{ fuel.dispenser_2 }} <span>L</span> 
                    </td>
                    <td>
                        <div class="d-flex">
                        <button @click="editFuel(fuel)" class="btn btn-primary">Edit</button>
                        <button @click="deleteFuel(fuel.id)" class="btn btn-danger">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a href="#" class="page-link" @click="fetchFuels(pagination.prev_page_url)">Previous</a></li>

                <li class="page-item disabled">
                    <a href="#" class="page-link">
                        Page {{ pagination.current_page }} of {{ pagination.last_page }}
                    </a>
                </li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a href="#" class="page-link" @click="fetchFuels(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default({
        data() {
          return {
            fuels: [],
            fuel: {
                id: '',
                tank: '',
                dispenser_1: '',
                dispenser_2: ''
            },
            fuel_id: '',
            pagination: {},
            edit: false
          } 
        },
        created() {
            this.fetchFuels();
        },

        methods: {
            fetchFuels(page_url) {
                let vm = this;
                page_url = page_url || '/api/fuels'
                fetch(page_url)
                .then(res => res.json())
                .then(res =>{
                    this.fuels = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.next
                }
                this.pagination = pagination;
            },
            deleteFuel(id){
                if(confirm("Are you Sure")){
                    fetch(`api/fuels/${id}`,{
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Fuel removed');
                        this.fetchFuels();
                    })
                    .catch(err => console.log(err));
                }
            },
            addFuel(){
                if(this.edit === false){
                    //add
                    fetch('api/fuel',{
                        method: 'post',
                        body: JSON.stringify(this.fuel),
                        headers:{
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.fuel.tank = '';
                        this.fuel.dispenser_1 = '';
                        this.fuel.dispenser_2 = '';
                        alert('Data added');
                        this.fetchFuels();
                    })
                    .catch(err => console.log(err));
                }else{
                    //Update
                    fetch('api/fuel',{
                        method: 'put',
                        body: JSON.stringify(this.fuel),
                        headers:{
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.fuel.tank = '';
                        this.fuel.dispenser_1 = '';
                        this.fuel.dispenser_2 = '';
                        alert('Data updated');
                        this.fetchFuels();
                    })
                    .catch(err => console.log(err));
                }

            },
            editFuel(fuel){
                    this.edit = true;
                    this.fuel.id = fuel.id;
                    this.fuel.fuel_id = fuel.id;
                    this.fuel.tank = fuel.tank; 
                    this.fuel.dispenser_1 = fuel.dispenser_1; 
                    this.fuel.dispenser_2 = fuel.dispenser_2; 
            }
        }
    });
</script>
