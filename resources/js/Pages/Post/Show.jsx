import { Link, router, usePage } from '@inertiajs/react';
import { format } from 'date-fns';
import { ru } from 'date-fns/locale';
import { deletePostUrl, editPostUrl, tagPostsUrl } from "../../route.js";
import Tags from '../../Components/Tags/Tags.jsx';
import Author from '../../Components/Author.jsx';
import DateTime from '../../Components/DateTime.jsx';
import Comments from '../../Components/Comments/Comments.jsx';
import SubscriptionButton from '../../Components/Subscriptions/SubscriptionButton.jsx';
import CommentForm from '../../Components/Comments/CommentForm.jsx';

export default function Show({ post, can_edit, can_delete }) {
    const { auth } = usePage().props;

    const isOwner = auth?.user?.id === post.author?.id;

    function destroy() {
        if (confirm('Удалить запись?')) {
            router.delete(deletePostUrl(post));
        }
    }

    return (
        <>
            <div className="card mb-4">
                <div className="card-body">
                    <div className="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1>{post.title}</h1>

                            <div className="text-muted">
                                Автор: <Author user={post.author} />
                                <SubscriptionButton user={post.author} className="btn-sm py-0 px-2 ms-2" />
                            </div>

                            <div className="text-muted small">
                                Создан: <DateTime date={post.created_at} />
                                {post.updated_at && post.created_at < post.updated_at &&
                                    <>ред. <DateTime date={post.updated_at} /></>
                                }
                            </div>
                        </div>

                        {isOwner && (can_edit || can_delete) && (
                            <div className="d-flex gap-2">
                                {can_edit && (
                                    <Link href={editPostUrl(post)} className="btn btn-outline-primary">
                                        Редактировать
                                    </Link>
                                )}

                                {can_delete && (
                                    <button onClick={destroy} className="btn btn-outline-danger">
                                        Удалить
                                    </button>
                                )}
                            </div>
                        )}
                    </div>

                    {post.hidden === true && (
                        <div className="alert alert-warning">
                            Эта запись скрыта
                        </div>
                    )}

                    <Tags tags={post.tags} className="mb-4" />

                    <div style={{ whiteSpace: 'pre-wrap' }}>
                        {post.content}
                    </div>
                </div>
            </div>

            <h3 className="mb-4">Комментарии</h3>
            <Comments comments={post.comments} className="mb-4" />
            <CommentForm post={post} />
        </>
    );
}
