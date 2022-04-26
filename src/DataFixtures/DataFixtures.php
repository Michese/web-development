<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\NewItem;
use App\Entity\User;

class DataFixtures
{
    public function userVadim(): User
    {
        $user = new User();
        $user->setFirstName('Вадим')
            ->setLastName('Куликов')
            ->setEmail('michese@mail.ru')
            ->setPhone('89046867942')
            ->setRoles(['ROLE_ADMIN'])
            ->setLastDayVisit(new \DateTimeImmutable('now'));

        return $user;
    }

    public function userHope(): User
    {
        $user = new User();
        $user->setFirstName('Надежда')
            ->setLastName('Зубкова')
            ->setEmail('only-hope@mail.ru')
            ->setPhone('89046764591')
            ->setRoles(['ROLE_ADMIN'])
            ->setLastDayVisit(new \DateTimeImmutable('now'));
        return $user;
    }

    public function userTest(): User
    {
        $user = new User();
        $user->setFirstName('Тест')
            ->setLastName('Тестович')
            ->setEmail('test@mail.ru')
            ->setPhone('89056912312')
            ->setRoles([])
            ->setLastDayVisit(new \DateTimeImmutable('now'));
        return $user;
    }

    public function firstCatNew(User $user): NewItem
    {
        $catNew = new NewItem();
        $catNew->setTitle('Кот занял первое место в Книге рекордов Гиннеса')
            ->setDescription('Котик по имени Мотимару стал самым популярным котом на YouTube')
            ->setText('Котик по имени Мотимару стал самым популярным котом на YouTube.

Японский кот Мотимару шотландской породы набрал на видеохостинге более 600 миллионов просмотров, за что удостоен награды и занесен в книгу рекордов Гиннеса. Это самый просматриваемый на YouTube представитель кошачьих.

Хозяева ведут канал с котиком с его 50-дневного возраста, с 30 ноября 2019 года. На канал выкладывались видео с повседневной жизнью котика. Котенок привлек зрителей милой внешностью и выразительной мордочкой.

Теперь Мотимару имеет на канале 1,4 миллиона подписчиков и быстро набирает на каждом видео миллионы просмотров.')
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setImage('\uploads\1.jpg')
            ->setAdmin($user);
        return $catNew;
    }

    public function secondCatNew(User $user): NewItem
    {
        $catNew = new NewItem();
        $catNew->setTitle('Ученые выяснили, что кошки знают свои имена')
            ->setDescription('Ученые из Японии провели эксперимент, чтобы выяснить, откликаются ли кошки на свое имя.')
            ->setText('Ученые из Японии провели эксперимент, чтобы выяснить, откликаются ли кошки на свое имя.

Для исследования взяли 80 кошек — как домашних, так и взятых напрокат из кошачьего кафе.

На первом этапе исследователи записали на диктофон голос хозяина или знакомого кошке человека. На аудио произносилась кличка кошки, а также 4 похожих по звучанию слова. Далее задачу усложнили, и люди на записи называли имена других кошек. В конце эксперимента кличку называл совсем незнакомый кошке человек.')
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setImage('\uploads\2.jpg')
            ->setAdmin($user);
        return $catNew;
    }

    public function thirdCatNew(User $user): NewItem
    {
        $catNew = new NewItem();
        $catNew->setTitle('Российская ветклиника наймет обнимателя котов')
            ->setDescription('Для любителей котиков нашлась вакансия мечты — ветеринарная клиника ищет обнимателя котов.')
            ->setText('Для любителей котиков нашлась вакансия мечты — ветеринарная клиника ищет обнимателя котов.

Такой работник понадобился одной из ветклиник города Черкассы. Главное требование к будущему работнику — любовь к животным.

Вакансия появилась из-за специфики работы в ветклиники. В стационаре постоянно находятся уличные коты, которым просто необходима любовь и внимание человека. Когда человек гладит кота, питомец перестает бояться и социализируется.

Ветклиника будет рада и просто добровольцам, которые будут приходить погладить котиков. Ветеринары также сообщили, что всем бездомным животным в клинике нужна постоянная семья.')
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setImage('\uploads\3.jpg')
            ->setAdmin($user);
        return $catNew;
    }

    public function firstComment(User $user, NewItem $new): Comment
    {
        $comment = new Comment();
        $comment->setIsActive(true)
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setNew($new)
            ->setUser($user)
            ->setText("Это лучший котик!");
        return $comment;
    }

    public function secondComment(User $user, NewItem $new): Comment
    {
        $comment = new Comment();
        $comment->setCreatedAt(new \DateTimeImmutable('now'))
            ->setNew($new)
            ->setUser($user)
            ->setText("Aaaaa люблю котов!");
        return $comment;
    }

    public function thirdComment(User $user, NewItem $new): Comment
    {
        $comment = new Comment();
        $comment->setIsActive(true)
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setNew($new)
            ->setUser($user)
            ->setText("Это же кооооотик :3");
        return $comment;
    }

    public function fourthComment(User $user, NewItem $new): Comment
    {
        $comment = new Comment();
        $comment->setCreatedAt(new \DateTimeImmutable('now'))
            ->setNew($new)
            ->setUser($user)
            ->setText("Почему тут одни коты >_> \n Видимо я не туда попал <_<");
        return $comment;
    }

    public function fifthComment(User $user, NewItem $new): Comment
    {
        $comment = new Comment();
        $comment->setIsActive(true)
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setNew($new)
            ->setUser($user)
            ->setText("Всем по котикам :3");
        return $comment;
    }
}