import { useForm } from '@inertiajs/react';
import Editor from '../../Components/Editor';

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        title: '',
        content: '',
        tags: '',
        hidden: false,
    });

    function submit(e) {
        e.preventDefault();

        post('/posts');
    }

    return (
        <>
            <div className="card">
                <div className="card-body">
                    <h1 className="mb-4">Создание записи</h1>

                    <form onSubmit={submit}>
                        <div className="mb-3">
                            <label className="form-label">Заголовок</label>

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
                            <label className="form-label">Контент</label>

                            <Editor
                                value={data.content}
                                onChange={(value) => setData('content', value)}
                            />

                            {errors.content && (
                                <div className="text-danger small mt-1">
                                    {errors.content}
                                </div>
                            )}
                        </div>

                        <div className="mb-3">
                            <label className="form-label">
                                Теги
                            </label>

                            <input
                                type="text"
                                className="form-control"
                                placeholder="laravel, react, inertia"
                                value={data.tags}
                                onChange={(e) =>
                                    setData('tags', e.target.value)
                                }
                            />

                            <div className="form-text">
                                Теги через запятую
                            </div>
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
                            Создать запись
                        </button>
                    </form>
                </div>
            </div>
        </>
    );
}
