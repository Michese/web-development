<template>
  <div class="heart" :class="heartClass">
    <svg viewBox="0 0 34 31" class="heart__img" xmlns="http://www.w3.org/2000/svg">
      <path
        d="M24.6402 0.801758C21.6596 0.801758 18.8908 2.28287 17.2264 4.76591L16.8826 5.21154L16.6535 4.9135C15.008 2.33815 12.2337 0.801758 9.2226 0.801758C4.08447 0.801758 0.355225 4.60481 0.355225 9.84403C0.355225 17.5801 14.0875 28.981 15.0889 29.8018C15.5619 30.2625 16.1801 30.516 16.8366 30.516C17.4931 30.516 18.1116 30.2626 18.5851 29.8011C19.59 28.9748 33.5076 17.3935 33.5076 9.84414C33.5067 4.60481 29.778 0.801758 24.6402 0.801758Z"
      />
    </svg>
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
  transition: background-color 0.2s linear;

  &_s_big {
    width: 65px;
    height: 65px;
  }

  &__img {
    width: 70%;
    fill: var(--color-gray);
    transition: fill 0.2s linear;
  }

  &__rating {
    position: absolute;
    transition: color 0.2s linear;
  }

  &:hover {
    background-color: var(--color-gray);
  }

  &:hover &__img {
    fill: var(--color-green);
  }

  &:hover &__rating {
    color: var(--color-gray);
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
