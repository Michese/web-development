import {mount, RouterLinkStub} from '@vue/test-utils'
import News from "../../components/News/News.vue";
import NewsApi from "../../api/NewsApi";


test('test render News component', async () => {
    const initialPage = "1";
    const testNews = await NewsApi.getNews(initialPage);

    const NewsWrapper = mount(News, {
        data() {
            return {
                news: testNews['hydra:member'],
                isLoading: false,
                totalCount: testNews['hydra:totalItems'],
            }
        },
        props: {
            page: initialPage,
        },
        global: {
            stubs: {
                RouterLink: RouterLinkStub,
            },
        },
    })
    const allCardBody = NewsWrapper.findAll('.card')
    expect(allCardBody.length).toBe(3);
    expect(allCardBody.every(card => !!card)).toBe(true);
    expect(NewsWrapper.html()).toContain('Кот занял первое место в Книге рекордов Гиннеса');
    expect(NewsWrapper.findAllComponents(RouterLinkStub)[0].props().to).toEqual({ name: 'New', params: { newId:
    testNews['hydra:member'][0].id} })
})