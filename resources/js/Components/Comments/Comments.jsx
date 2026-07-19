import Comment from "../Comment";

export default function Comments({ comments, className }) {
    if (!comments || comments.length === 0) {
        return (
            <div className={`text-muted ${className || ''}`}>
                Комментариев пока нет.
            </div>
        );
    }

    return (
        <div className={`d-flex flex-column gap-3 ${className || ''}`}>
            {comments.map((comment) => (
                <Comment comment={comment} key={comment.id} />
            ))}
        </div>
    );
};
