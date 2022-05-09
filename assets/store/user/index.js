import { inject, reactive } from 'vue';
import UserApi from "../../api/UserApi";

export const userSymbol = Symbol('user');
export const useStateUser = () => inject(userSymbol);
export const createStateUser = () => {
    const state = reactive({
        user: null,
    });
    const fetchUser = async () => {
        const { user } = await UserApi.getUser();
        if (user) state.user = user;
        return user;
    };

    const logoutUser = async () => {
        const { success } = await UserApi.logout();
        if (success) state.user = null;
        return !!success;
    };

    const loginUser = async data => {
        const { data: { token } } = await UserApi.login(data);
        if (token) await fetchUser();
        return state.user;
    };

    const registerUser = async data => {
        const { data: { result } } = await UserApi.register(data);
        if (result) return await loginUser({
            email: data.email,
            password: data.password,
        });
        else result;
    };

    return { fetchUser, state, logoutUser, loginUser, registerUser };
};

export const stateUser = createStateUser();
