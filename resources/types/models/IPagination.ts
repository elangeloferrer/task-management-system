export interface IPagination {
    current_page: number;
    next_page_url: string;
    prev_page_url: string;
    per_page: number;
    total_items: number;
    total_pages: number;
}
