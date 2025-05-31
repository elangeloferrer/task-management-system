export interface INotification {
    type: "success" | "error";
    message: string;
    is_triggered: boolean;
}
