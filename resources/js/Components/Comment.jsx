import { format } from "date-fns";
import { ru } from "date-fns/locale";
import Author from "./Author";
import DateTime from "./DateTime";

export default function Comment({ comment }) {
  return (
    <div className="border rounded p-3">
      <div className="fw-semibold">
        {comment.author && <Author user={comment.author} />}
      </div>

      <div className="small text-muted mb-2">
        <DateTime date={comment.created_at} />
      </div>

      <div>{comment.content}</div>
    </div>
  );
};
