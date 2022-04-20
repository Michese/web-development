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
        await UserApi.logout();
        state.user = null;
        return true;
    };

    const loginUser = async data => {
        const { data: { user } } = await UserApi.login(data);
        if (user) state.user = user;
        return user;
    };

    const registerUser = async data => {
        const { data: { result } } = await UserApi.register(data);
        console.log('result', result);
        if (result) return await loginUser({
            username: data.email,
            password: data.password,
        });
        else result;
    };

    return { fetchUser, state, logoutUser, loginUser, registerUser };
};

export const stateUser = createStateUser();
