import Editor from '../../Components/Editor';
import { useForm } from '@inertiajs/react';

export default function Edit({ post }) {
    const { data, setData, put, processing, errors } = useForm({
        title: post.title,
        content: post.content,
        tags: post.tags.map((t) => t.name).join(', '),
        hidden: post.hidden,
    });

    function submit(e) {
        e.preventDefault();

        put(`/posts/${post.id}`);
    }

    return (
        <>
            <div className="card">
                <div className="card-body">
                    <h1 className="mb-4">
                        Редактирование записи
                    </h1>

                    <form onSubmit={submit}>
                        <div className="mb-3">
                            <label className="form-label">
                                Заголовок
                            </label>

                            <input
                                type="text"
                                className="form-control"
                                value={data.title}
                                onChange={(e) =>
                                    setData('title', e.target.value)
                                }
                            />

                            {errors.title && (
                                <div className="text-danger small mt-1">
                                    {errors.title}
                                </div>
                            )}
                        </div>

                        <div className="mb-3">
                            <label className="form-label">
                                Контент
                            </label>

                            <Editor
                                value={data.content}
                                onChange={(value) =>
                                    setData('content', value)
                                }
                            />
                        </div>

                        <div className="mb-3">
                            <label className="form-label">
                                Теги
                            </label>

                            <input
                                type="text"
                                className="form-control"
                                value={data.tags}
                                onChange={(e) =>
                                    setData('tags', e.target.value)
                                }
                            />
                        </div>

                        <div className="form-check mb-4">
                            <input
                                type="checkbox"
                                className="form-check-input"
                                checked={data.hidden}
                                onChange={(e) =>
                                    setData('hidden', e.target.checked)
                                }
                            />

                            <label className="form-check-label">
                                Скрытая запись
                            </label>
                        </div>

                        <button
                            className="btn btn-primary"
                            disabled={processing}
                        >
                            Сохранить
                        </button>
                    </form>
                </div>
            </div>
        </>
    );
}
