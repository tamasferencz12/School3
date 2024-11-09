export class Cell {
    constructor(images) {
        this.images = images;
        this.currentIndex = 0;
    }

    nextImage() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
        return this.images[this.currentIndex];
    }
}