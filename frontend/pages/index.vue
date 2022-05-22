<template>
  <diV>
    <MenuBar></MenuBar>
    <div class="float-right m-3">
      <b-button @click="showModal">Create</b-button>

      <b-modal id="modal" title="Add New User" hide-footer>
        <b-form @submit="onSubmit">
          <b-form-group id="input-group-2" label="Name:" label-for="input-2">
            <b-form-input
              id="input-2"
              v-model="form.name"
              placeholder="Enter name"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="input-group-1"
            label="Email address:"
            label-for="input-1"
          >
            <b-form-input
              id="input-1"
              v-model="form.email"
              type="email"
              placeholder="Enter email"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-5" label="Image:">
            <b-form-file
              id="checkboxes-5"
              accept="image/*"
              required
              v-model="form.image"
              placeholder="Choose a file or drop it here..."
              drop-placeholder="Drop file here..."
            ></b-form-file>
          </b-form-group>

          <b-form-group
            id="input-group-4"
            label="Gender:"
            v-slot="{ ariaDescribedby }"
          >
            <b-form-radio-group
              v-model="form.gender"
              id="checkboxes-4"
              :aria-describedby="ariaDescribedby"
              required
            >
              <b-form-radio value="male" selected>Male</b-form-radio>
              <b-form-radio value="female">Female</b-form-radio>
            </b-form-radio-group>
          </b-form-group>

          <b-form-group label="Skills:" v-slot="{ ariaDescribedby }">
            <b-form-checkbox-group
              id="checkbox-group-2"
              v-model="form.skills"
              :aria-describedby="ariaDescribedby"
              name="flavour-2"
            >
              <b-form-checkbox value="laravel">Laravel</b-form-checkbox>
              <b-form-checkbox value="code-igniter"
                >Code-igniter</b-form-checkbox
              >
              <b-form-checkbox value="ajax">Ajax</b-form-checkbox>
              <b-form-checkbox value="vue js">VUE JS</b-form-checkbox>
              <b-form-checkbox value="mysql">MYSQL</b-form-checkbox>
              <b-form-checkbox value="api">API</b-form-checkbox>
            </b-form-checkbox-group>
            <small v-if="errSkill" class="text-danger"
              >Checked atleast one skill.</small
            >
          </b-form-group>

          <b-button type="submit" variant="primary">Save</b-button>
        </b-form>
      </b-modal>


       <b-modal id="edit" title="Edit User" hide-footer>
        <form >
          <b-form-group id="input-group-2" label="Name:" label-for="input-2">
            <b-form-input
              id="input-2"
              v-model="editUser.name"
              placeholder="Enter name"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="input-group-1"
            label="Email address:"
            label-for="input-1"
          >
            <b-form-input
              id="input-1"
              v-model="editUser.email"
              type="email"
              placeholder="Enter email"
              required
            ></b-form-input>
          </b-form-group>
 <b-form-group label="Current Image:">
          <img :src="editUser.img" height="150" width="150" />
 </b-form-group>
          <b-form-group id="input-group-5" label="Image:">
            <b-form-file
              id="checkboxes-5"
              accept="image/*"
              v-model="editUser.image"
              placeholder="Choose a file or drop it here..."
              drop-placeholder="Drop file here..."
            ></b-form-file>
          </b-form-group>

          <b-form-group
            id="input-group-4"
            label="Gender:"
            v-slot="{ ariaDescribedby }"
          >
            <b-form-radio-group
              v-model="editUser.gender"
              id="checkboxes-4"
              :aria-describedby="ariaDescribedby"
              required
            >
              <b-form-radio value="male" selected>Male</b-form-radio>
              <b-form-radio value="female">Female</b-form-radio>
            </b-form-radio-group>
          </b-form-group>

          <b-form-group label="Skills:" v-slot="{ ariaDescribedby }">
            <b-form-checkbox-group
              id="checkbox-group-2"
              v-model="editUser.skills"
              :aria-describedby="ariaDescribedby"
              name="flavour-2"
            >
              <b-form-checkbox value="laravel">Laravel</b-form-checkbox>
              <b-form-checkbox value="code-igniter"
                >Code-igniter</b-form-checkbox
              >
              <b-form-checkbox value="ajax">Ajax</b-form-checkbox>
              <b-form-checkbox value="vue js">VUE JS</b-form-checkbox>
              <b-form-checkbox value="mysql">MYSQL</b-form-checkbox>
              <b-form-checkbox value="api">API</b-form-checkbox>
            </b-form-checkbox-group>
            <small v-if="errSkill" class="text-danger"
              >Checked atleast one skill.</small
            >
          </b-form-group>

          <b-button variant="primary" @click="onUpdate">Update</b-button>
        </form>
      </b-modal>
    </div>
    <table class="table mt-3">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Image</th>
          <th scope="col">name</th>
          <th scope="col">email</th>
          <th scope="col">gender</th>
          <th scope="col">skills</th>
          <th scope="col">action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in user" :key="row.id">
          <th scope="row">{{ row.id }}</th>
          <td><img :src="row.img" height="150" width="150" /></td>
          <td>{{ row.name }}</td>
          <td>{{ row.email }}</td>
          <td>{{ row.gender }}</td>
          <td>
            <small v-for="{ skill, index } in row.skills" :key="index">
              {{ skill }} ,
            </small>
          </td>
          <td>
             <button class="sm btn btn-info" @click="onEdit(row)"
              >Edit</button
            >
            <button class="sm btn btn-danger" @click="onDelete(row.id)"
              >Delete</button
            >
          </td>
        </tr>
      </tbody>
    </table>
  </diV>
</template>

<script>
import MenuBar from "~/components/Menu.vue";
export default {
  name: "IndexPage",
  data() {
    return {
      user: null,
      errSkill: false,
      form: {
        email: "",
        name: "",
        gender: "male",
        skills: [],
        image: null,
      },
      editUser:{
        email: "",
        name: "",
        gender: "",
        skills: [],
        image: null,
        img:null,
        id:null,
      },
    };
  },
  components: { MenuBar },
  methods: {
    onEdit(data){
      this.editUser.id = data.id;
       this.editUser.name = data.name;
      this.editUser.email = data.email;
       this.editUser.gender = data.gender;
        this.editUser.skills = data.skill;
         this.editUser.img = data.img;
      this.$bvModal.show("edit");
    },
   async onUpdate(event){
     console.log(this.editUser);
         event.preventDefault();
          if (this.editUser.skills.length < 1) {
        this.errSkill = true;
      } else {
        this.errSkill = false;

         const formData = new FormData();

        formData.append("name", this.editUser.name);
        formData.append("email", this.editUser.email);

        if( this.editUser.image){
          formData.append("image", this.editUser.image, this.editUser.image.name);
        }
        
        formData.append("gender", this.editUser.gender);
        formData.append("_method","PUT");

        this.editUser.skills.forEach((row) => {
          formData.append("skill[]", row);
        });

        await this.$axios.$post("/user-info/"+this.editUser.id, formData);
        this.fetchData();
        this.$bvModal.hide("edit");
      }
    },
   async onDelete(id) {
      await this.$axios.$delete("/user-info/"+id);
       this.fetchData();
    },
    showModal() {
      this.$bvModal.show("modal");
    },
    async onSubmit(event) {
      event.preventDefault();
      if (this.form.skills.length < 1) {
        this.errSkill = true;
      } else {
        this.errSkill = false;
        const formData = new FormData();
        formData.append("name", this.form.name);
        formData.append("email", this.form.email);
        formData.append("image", this.form.image, this.form.image.name);
        formData.append("gender", this.form.gender);
        this.form.skills.forEach((row) => {
          formData.append("skill[]", row);
        });

        await this.$axios.$post("/user-info", formData);
        this.fetchData();
        this.$bvModal.hide("modal");
      }
    },

    async fetchData() {
      const res = await this.$axios.$get("/user-info");
      this.user = res.data;
    },
  },
  fetch() {
    this.fetchData();
  },
};
</script>
