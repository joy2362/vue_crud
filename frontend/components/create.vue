<template>
  <div class="float-right mx-2">
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
            <b-form-checkbox value="code-igniter">Code-igniter</b-form-checkbox>
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
  </div>
</template>

<script>
export default {
  name: "createUser",

  data() {
    return {
      errSkill: false,
      form: {
        email: "",
        name: "",
        gender: "male",
        skills: [],
        image: null,
      },
    };
  },

  methods: {
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
          console.log(row);
        });

        //const res = await this.$axios.$post("/user-info", formData);
        //this.$bvModal.hide("modal");
      }
    },
  },
};
</script>

<style></style>
