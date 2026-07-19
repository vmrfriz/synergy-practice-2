import { Link, router, usePage } from '@inertiajs/react';
import { useState } from 'react';
import { format } from 'date-fns';
import { pluralize } from '../utils/helpers'
import { ru } from 'date-fns/locale';
import { logout as logoutRoute } from '../route'
import Subscriptions from '../Components/Subscriptions/Subscriptions';
import PostItemCompact from '../Components/PostItem/PostItemCompact';
import SubscriptionButton from '../Components/Subscriptions/SubscriptionButton';

export default function Profile({user = {}, subscribed = false, posts = [], subscriptions = [], feedPosts = []}) {
    const { auth } = usePage().props;

    const [tab, setTab] = useState('feed');

    const tabClass = (tabName) =>
        tabName === tab ? 'btn-primary' : 'btn-outline-primary';

    const logout = () => router.post('/logout', {}, {
        onBefore: () => confirm('Вы уверены, что хотите выйти из аккаунта?'),
    });

    return (
        <>
            <div className="row g-4">
                <div className="col-lg-3">
                    <div className="card">
                        <div className="card-body">
                            <h4 className="mb-1">{user.name}</h4>

                            {auth.user.id === user.id ? (
                                <div className="mb-4">
                                    <div className="text-muted small">
                                        {user.email}
                                    </div>
                                    <div><span className="badge bg-primary">Это Вы</span></div>
                                </div>
                            ) : (
                                <div className="mb-4">
                                    <SubscriptionButton user={user} />
                                </div>
                            )}

                            <div className="d-grid gap-2">
                                <button
                                    className={`btn ${tabClass('feed')}`}
                                    onClick={() => setTab('feed')}
                                >
                                    Лента
                                </button>

                                <button
                                    className={`btn ${tabClass('posts')}`}
                                    onClick={() => setTab('posts')}
                                >
                                    Мои записи
                                </button>

                                <button
                                    className={`btn ${tabClass('subscriptions')}`}
                                    onClick={() => setTab('subscriptions')}
                                >
                                    Подписки
                                </button>

                                <Link
                                    as="button"
                                    type="button"
                                    className="btn btn-outline-danger"
                                    onClick={logout}
                                >
                                    Выйти
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="col-lg-9">
                    {tab === 'feed' && (
                        <div>
                            <h3 className="mb-4">Лента</h3>

                            {feedPosts.data.length === 0 && (
                                <div className="text-muted">
                                    Лента пока пустая.
                                </div>
                            )}

                            <div className="d-flex flex-column gap-3">
                                {feedPosts.data.map((post) => (
                                    <PostItemCompact post={post} key={post.id} />
                                ))}
                            </div>
                        </div>
                    )}

                    {tab === 'posts' && (
                        <div>
                            <div className="d-flex justify-content-between align-items-center mb-4">
                                <h3 className="mb-0">Мои записи</h3>

                                <Link
                                    href="/posts/create"
                                    className="btn btn-primary"
                                >
                                    Создать
                                </Link>
                            </div>

                            {posts.data.length === 0 && (
                                <div className="text-muted">
                                    Записей пока нет.
                                </div>
                            )}

                            <div className="d-flex flex-column gap-3">
                                {posts.data.map((post) => (
                                    <PostItemCompact post={post} key={post.id} />
                                ))}
                            </div>
                        </div>
                    )}

                    {tab === 'subscriptions' && (
                        <div>
                            <h3 className="mb-4">Подписки</h3>
                            <Subscriptions users={subscriptions.data} />
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
