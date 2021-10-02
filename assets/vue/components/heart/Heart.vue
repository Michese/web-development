<template>
  <div class="heart" :class="heartClass">
    <img src="@/vue/components/heart/assets/heart.svg" alt="heart" class="heart__img" />
    <span class="heart__rating" :class="ratingClass">{{ rating }}</span>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { Prop } from 'vue-property-decorator';

@Options({
  name: 'Heart',
})
export default class Heart extends Vue {
  @Prop({
    type: Number,
    required: true,
  })
  rating!: number;

  @Prop({
    type: Number,
    required: false,
    default: () => 18,
  })
  size!: number;

  get ratingClass(): { oronia: boolean; maria: boolean } {
    return {
      oronia: this.size === 18,
      maria: this.size === 24,
    };
  }

  get heartClass(): { heart_s_big: boolean } {
    return {
      heart_s_big: this.size === 24,
    };
  }
}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.heart {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50px;
  height: 50px;
  background-color: var(--color-green);
  border-radius: 50%;

  &_s_big {
    width: 65px;
    height: 65px;
  }

  &__img {
    width: 70%;
  }

  &__rating {
    position: absolute;
  }
}

@include media(lg) {
  .heart {
    &_s_big {
      width: 85px;
      height: 85px;
    }
  }
}
</style>
