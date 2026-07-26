import { useForm, usePage } from "@inertiajs/react";
import { storeCommentUrl } from "../../route";

export default function CommentForm(props) {
    const { data, setData, reset, post, processing, errors } = useForm({
        content: '',
    });

    const { auth } = usePage().props;

    if (! auth.user) {
        return null;
    }

    const send = () => post(storeCommentUrl(props.post), { onSuccess: () => reset() });

    return (
        <div>
            <textarea
                className={`form-control mb-2 ${errors.content ? 'is-invalid' : ''}`}
                placeholder="Текст комментария"
                value={data.content}
                onChange={(e) => setData('content', e.target.value)}
            />
            {errors.content && <div className="invalid-feedback mb-2">{errors.content}</div>}

            <button
                type="button"
                onClick={send}
                disabled={processing}
                className={`btn btn-primary ${processing ? 'progress-bar progress-bar-striped progress-bar-animated' : ''}`.trim()}
            >
                Отправить
            </button>
        </div>
    );
};
