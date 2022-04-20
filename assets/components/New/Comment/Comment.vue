<template>
  <div class="card mb-1">
    <div class="card-header bg-custom-gray d-flex justify-content-between align-items-center">
      <span class="card-header__name"><b class="me-2">{{ item.user.firstName }}</b><i>{{ createdAt }}</i></span>
      <button v-if="canApprove" class="card__approve-btn" @click="approve">
        <svg width="30" height="30" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g clip-path="url(#clip0_816_6)">
            <path
                d="M25 0C20.0555 0 15.222 1.46622 11.1108 4.21326C6.99953 6.96029 3.79521 10.8648 1.90302 15.4329C0.010832 20.0011 -0.484251 25.0277 0.480379 29.8773C1.44501 34.7268 3.82603 39.1814 7.32234 42.6777C10.8187 46.174 15.2732 48.555 20.1228 49.5196C24.9723 50.4843 29.9989 49.9892 34.5671 48.097C39.1353 46.2048 43.0397 43.0005 45.7868 38.8893C48.5338 34.778 50 29.9445 50 25C49.9928 18.3718 47.3565 12.0172 42.6697 7.33032C37.9828 2.64348 31.6282 0.00723772 25 0V0ZM25 47.6562C20.519 47.6562 16.1387 46.3275 12.4129 43.838C8.68707 41.3485 5.78316 37.8101 4.06837 33.6702C2.35357 29.5303 1.9049 24.9749 2.77909 20.58C3.65329 16.1851 5.81109 12.1481 8.97962 8.97961C12.1482 5.81108 16.1851 3.65328 20.58 2.77908C24.9749 1.90489 29.5303 2.35356 33.6702 4.06835C37.8101 5.78315 41.3485 8.68706 43.838 12.4129C46.3275 16.1387 47.6563 20.519 47.6563 25C47.649 31.0066 45.2597 36.7651 41.0124 41.0124C36.7651 45.2597 31.0066 47.649 25 47.6562Z"
                fill="#90BE6D"/>
            <path
                d="M34.3362 16.5466L19.6955 30.945L15.6916 26.7302C15.4757 26.5134 15.1836 26.3897 14.8777 26.3854C14.5718 26.3811 14.2763 26.4966 14.0545 26.7073C13.8326 26.918 13.7019 27.207 13.6903 27.5128C13.6787 27.8185 13.7871 28.1166 13.9924 28.3435L18.8166 33.4216C18.9237 33.534 19.0521 33.624 19.1942 33.6863C19.3364 33.7487 19.4895 33.7822 19.6448 33.7849H19.6643C19.9712 33.7846 20.2657 33.664 20.4846 33.4489L35.9729 18.2146C36.0827 18.1066 36.1701 17.978 36.2302 17.8363C36.2903 17.6945 36.3219 17.5423 36.3231 17.3883C36.3244 17.2343 36.2953 17.0816 36.2376 16.9388C36.1798 16.7961 36.0945 16.6661 35.9866 16.5564C35.8786 16.4466 35.75 16.3591 35.6083 16.299C35.4665 16.239 35.3143 16.2074 35.1603 16.2061C35.0063 16.2048 34.8536 16.2339 34.7108 16.2916C34.5681 16.3494 34.4381 16.4347 34.3284 16.5427L34.3362 16.5466Z"
                fill="#90BE6D"/>
          </g>
          <defs>
            <clipPath id="clip0_816_6">
              <rect width="50" height="50" fill="white"/>
            </clipPath>
          </defs>
        </svg>
      </button>
    </div>
    <div class="card-body">
      <blockquote class="blockquote mb-0">
        <p v-html="item.text"/>
      </blockquote>
    </div>
  </div>
</template>

<script>
import NewsApi from "../../../api/NewsApi";
import {userSymbol} from "../../../store";

export default {
  name: "Comment",
  emits: [],
  props: {
    item: {
      type: Object,
      required: true,
    },
    newId: {
      type: Number,
      required: true,
    },
  },
  inject: {
    stateUser: {
      from: userSymbol,
    },
  },
  computed: {
    createdAt() {
      return this.item?.createdAt ? new Date(this.item.createdAt).toLocaleString() : '';
    },
    user() {
      return this.stateUser.state.user;
    },
    canApprove() {
      return this.isAdmin && this.item.admin === null;
    },
    isAdmin() {
      return !!this.user?.roles.includes('ROLE_ADMIN');
    },
  },
  methods: {
    async approve() {
      const { data: { result } } = await NewsApi.approveComment(this.newId, this.item.id)
      if (result) this.$emit('fetch-new');
    },
  },
}
</script>

<style lang="scss" scoped>
.card {
  &-header_custom {
    background-color: var(--custom-blue);
  }

  &-header__name {
    font-size: 1.2em;
  }

  &__approve-btn {
    border: none;
    background-color: transparent;
    width: 30px;
    height: 30px;
  }
}

</style>