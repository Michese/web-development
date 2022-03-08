<template>
  <div class="profile">
    <profile-info v-if="user" />
    <gallery-section :is-profile="true" />
  </div>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import GallerySection from '@/vue/components/generalPage/gallerySection/GallerySection.vue';
import ProfileInfo from '@/vue/components/profile/profileInfo/ProfileInfo.vue';
import { InjectReactive, Watch } from 'vue-property-decorator';
import { routerEnum } from '@/enums';
import { TUser } from '@/types';

@Options({
  name: 'Profile',
  components: { GallerySection, ProfileInfo },
})
export default class Profile extends Vue {
  @InjectReactive('user') readonly user?: TUser | null;
  @Watch('user', { immediate: true }) wUser(): void {
    if (this.user === undefined) this.$router.push(routerEnum.generalPage);
  }
}
</script>

<style scoped>
.profile {
  padding-top: 100px;
}
</style>