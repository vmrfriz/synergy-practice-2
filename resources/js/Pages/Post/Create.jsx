import { useForm } from '@inertiajs/react';
import Editor from '../../Components/Editor';
import CustomInput from '../../Components/CustomInput';
import TagInput from '../../Components/Tags/TagInput';
import { createPostUrl } from '../../route';
import { useEffect } from 'react';

export default function Create({ tags }) {
    const { data, setData, post, processing, errors } = useForm({
        title: '',
        slug: '',
        content: '',
        hidden: false,
        tags: [],
    });

    const bind = (name) => ({
        value: data[name],
        error: errors[name],
        onChange: (value) => setData(name, value)
    });

    function submit(e) {
        e.preventDefault();

        post(createPostUrl());
    }

    return (
        <>
            <div className="card">
                <div className="card-body">
                    <h1 className="mb-4">Создание записи</h1>

                    <form onSubmit={submit}>
                        <CustomInput {...bind('title')}>Заголовок</CustomInput>
                        <CustomInput {...bind('slug')} placeholder="my-post-slug">SEO slug</CustomInput>

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
                            <label className="form-label">Теги</label>

                            <TagInput
                                tags={tags}
                                value={data.tags}
                                onChange={(tags) => setData('tags', tags)}
                            />

                            {errors.tags && (
                                <div className="text-danger small mt-1">
                                    {errors.tags}
                                </div>
                            )}
                        </div>

                        <div className="form-check mb-4">
                            <input
                                id="hidden-checkbox"
                                type="checkbox"
                                className="form-check-input"
                                checked={data.hidden}
                                onChange={(e) =>
                                    setData('hidden', e.target.checked)
                                }
                            />

                            <label htmlFor="hidden-checkbox" className="form-check-label">
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
