<template>
  <div class="container">
    <h1 class="text-center mb-3">{{ isEdit ? 'Редактирование'  : 'Добавление новой' }} новости</h1>
    <mim-spinner v-if="isLoading" />
    <form v-else action="#" method="post" class="create-new__form mb-3" ref="form" @submit.prevent="onSubmit">
      <div class="form__email">
        <h3>Название</h3>
        <div class="input-group mb-3">
          <input v-model="title" type="text" name="username" class="form-control" placeholder="Название"
                 aria-label="email" aria-describedby="email" required oninvalid="this.setCustomValidity('Необходмо ввести название')">
        </div>
      </div>


      <div class="form__description">
        <h3>Описание</h3>
        <div class="input-group mb-3">
        <textarea v-model="description" name="description" class="form-control" placeholder="Описание"
                  aria-label="description" aria-describedby="description" required oninvalid="this.setCustomValidity('Необходмо ввести описание')"/>
        </div>
      </div>

      <div class="form__text">
        <h3>Текст</h3>
        <textarea v-model="text" name="text" class="form-control text__textarea" placeholder="Текст" aria-label="text"
                  aria-describedby="text" required oninvalid="this.setCustomValidity('Необходмо ввести текст')"/>
      </div>

     <div class="form__image">
       <div class="input-group mb-3">
         <input id="image" type="file" accept="image/jpeg" name="image" :class="{ 'd-none': !!image }" class="from__input-image-body" placeholder="image" aria-label="image"
                aria-describedby="image" :required="!isEdit" @change="changeImage" oninvalid="this.setCustomValidity('Необходмо добавить картинку')" />
       </div>

       <label for="image" class="text-center w-100">
         <img class="form__input-image mb-2 w-50" :src="image" alt="">
       </label>
     </div>

      <div class="form__submit text-center w-100" >
        <input type="submit" :value="isEdit ? 'Редактировать' : 'Добавить'" class="btn bg-custom-blue text-white text-center">
      </div>
    </form>
  </div>
</template>

<script>
import {userSymbol} from "../../store/user";
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
    },
    newId() {
      if (!this.newId) {
        this.isLoading = true;
        this.title = '';
        this.description = '';
        this.text = '';
        this.image = '';
        this.isLoading = false;
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
.create-new__form {
  display: grid;
  grid-template-areas:
            "title text text"
            "description text text"
            "image image image"
            "submit submit submit";
  grid-template-rows: auto auto auto auto;
  grid-gap: 15px;
}

.form {
  &__title {
    grid-area: title;
  }

  &__description {
    grid-area: description;
  }

  &__text {
    height: max-content;
    grid-area: text;
  }


  &__image {
    cursor: pointer;
    grid-area: image;
  }

  &__input-image-body {
    display: none;
  }

  &__image:empty &__input-image-body {
    display: block;
  }

  &__submit {
    grid-area: submit;
  }

  &__input-image {
    max-height: 300px;
   }
}

.text__textarea {
  height: 175px;
  grid-column: 3;
  //height: -webkit-fill-available;
}
</style>