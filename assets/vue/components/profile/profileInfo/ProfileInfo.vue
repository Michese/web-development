<template>
  <section class="profile-info container">
    <h2 class="profile-info__section-caption section-caption">Личный кабинет</h2>

    <span class="profile-info__content crephusa"><strong>Роль:</strong> {{ user.role }}</span>
    <span class="profile-info__content crephusa"><strong>Email:</strong> {{ user.email }}</span>
    <span class="profile-info__content crephusa"><strong>Телефон:</strong> {{ user.phone }}</span>
    <span class="profile-info__content crephusa"><strong>Дата последнего входа:</strong> {{ date }}</span>
  </section>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { InjectReactive } from 'vue-property-decorator';
import { TUser } from '@/types';

@Options({
  name: 'ProfileInfo',
})
export default class ProfileInfo extends Vue {
  @InjectReactive('user') readonly user!: TUser;
  get date(): string {
    const date = new Date(this.user.last_login_date.date + 'Z');
    date.setHours(date.getHours() + this.user.last_login_date.timezone_type);
    return Intl.DateTimeFormat('ru-RU', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: 'numeric',
      minute: 'numeric',
      second: 'numeric',
      timeZone: this.user.last_login_date.timezone,
    }).format(date);
  }
}
</script>

<style lang="scss" scoped>
.profile-info {
  display: flex;
  flex-direction: column;
  padding: 15px;

  &__section-caption {
    align-self: center;
    text-align: center;
    margin-bottom: 10px;
  }

  &__content {
    &> strong {
      font-size: 1.1em;
      color: black;
    }

    &:not(:last-child) {
      margin-bottom: 5px;
    }
   }
}
</style>