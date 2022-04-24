import { inject, reactive } from 'vue';

export const notificationSymbol = Symbol('notification');
export const useStateNotification = () => inject(notificationSymbol);
export const createStateNotification = () => {
    const state = reactive({
        notifications: [],
    });
    const addNotification = async (notification) => {
        state.notifications.push(notification);

        setTimeout(() => {
            const index = state.notifications.indexOf(notification);
            console.warn('notification', state.notifications[index]);
            if (index > -1) state.notifications.splice(index, 1);
        }, 30000);
    };

    return { addNotification, state };
};

export const stateNotification = createStateNotification();
