<template>
  <div class="container">
    <h1 class="text-center mb-3">{{ isEdit ? 'Редактирование'  : 'Добавление новой' }} новости</h1>
    <mim-spinner v-if="isLoading" />
    <form v-else action="#" method="post" class="user-login__form d-flex flex-column align-items-center mb-4" ref="form" @submit.prevent="onSubmit">
      <div class="input-group mb-3 w-50">
        <input v-model="title" type="text" name="username" class="form-control" placeholder="Название"
               aria-label="email" aria-describedby="email" required>
      </div>

      <div class="input-group mb-3 w-50">
        <textarea v-model="description" name="description" class="form-control" placeholder="Описание"
                  aria-label="description" aria-describedby="description" rows="5" required/>
      </div>

      <div class="input-group mb-3 w-50">
        <textarea v-model="text" name="text" class="form-control" placeholder="Текст" aria-label="text"
                  aria-describedby="text" rows="20" required/>
      </div>

      <div class="input-group mb-3 w-50">
        <input type="file" accept="image/jpeg" name="image" class="form-control" placeholder="image" aria-label="image"
                  aria-describedby="image" :required="!isEdit" @change="changeImage" />
      </div>

      <img class="form__image mb-2 w-50" :src="image" alt="">


      <input type="submit" :value="isEdit ? 'Редактировать' : 'Добавить'" class="btn bg-custom-blue text-white">
    </form>
  </div>
</template>

<script>
import {userSymbol} from "../../store";
import NewsApi from "../../api/NewsApi";
import MimSpinner from "../../ui/MimSpinner/MimSpinner";

export default {
  name: "CreateNew",
  components: {MimSpinner},
  inject: {
    stateUser: {
      from: userSymbol,
    }
  },
  props: {
    newId: {
      type: String,
      required: false,
      default: null,
    },
  },
  watch: {
    user: {
      immediate: true,
      handler() {
        if (!this.user || !this.user.roles.includes("ROLE_ADMIN")) this.$router.push({name: 'Home'});
      }
    }
  },
  data: () => ({
    title: '',
    description: '',
    text: '',
    image: '',
    isLoading: true,
  }),
  computed: {
    user() {
      return this.stateUser.state.user;
    },
    isEdit() {
      return !!this.newId;
    }
  },
  created() {
    if (this.isEdit) {
      NewsApi.getNew(this.newId).then(({newItem: {title, description, text, image}}) => {
        this.title = title;
        this.description = description;
        this.text = text;
        this.image = image;
      }).finally(() => {
        this.isLoading = false;
      });
    } else this.isLoading = false;
  },
  methods: {
    async onSubmit() {
      if (this.isEdit) {
        const { data: { result } } = await NewsApi.changeNew(this.newId, {
          title: this.title,
          description: this.description,
          text: this.text,
          image: this.image,
        })

        if (result) await this.$router.push({name: 'New', params: {newId: result}});
      } else {
          if (this.image) {
            const { data: { result } } = await NewsApi.createNew({
              title: this.title,
              description: this.description,
              text: this.text,
              image: this.image,
            })

            if (result) await this.$router.push({name: 'New', params: {newId: result}});
          }
      }
    },
    async changeImage() {
      const fullForm = new FormData(this.$refs.form),
          image = fullForm.get('image'),
          fileForm = new FormData();

      fileForm.append('file', image, image.name);

      const { data: { result } } = await NewsApi.uploadFile(fileForm)

      if (result) this.image = result;
    },
  },
}
</script>

<style lang="scss" scoped>
.form {
  &__image {
    max-height: 700px;
   }
}
</style>