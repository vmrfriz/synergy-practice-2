import { useForm } from "@inertiajs/react";
import { storeCommentUrl } from "../../route";

export default function CommentForm(props) {
    const { data, post, processing, errors } = useForm({
        content: '',
    });

    const send = () => post(storeCommentUrl(props.post));

    return (
        <div>
            <textarea
                className="form-control mb-2"
                placeholder="Текст комментария"
                onChange={(e) => data.content = e.target.value}
            >
                {data.content}
            </textarea>
            <button
                type="button"
                onClick={send}
                className={`btn btn-primary ${processing ? 'progress-bar progress-bar-striped progress-bar-animated' : ''}`.trim()}
            >Отправить</button>
        </div>
    );
};
