<div
    x-data="{
        canvas: null,
        ctx: null,
        isDrawing: false,
        lastX: 0,
        lastY: 0,
        init() {
            this.canvas = this.$refs.canvas;
            this.ctx = this.canvas.getContext('2d');
            this.ctx.strokeStyle = '{{ $strokeColor }}';
            this.ctx.lineWidth = {{ $strokeWidth }};
            this.ctx.lineCap = 'round';
            this.ctx.lineJoin = 'round';
            this.clear();
        },
        startDrawing(e) {
            this.isDrawing = true;
            [this.lastX, this.lastY] = this.getPos(e);
        },
        draw(e) {
            if (!this.isDrawing) return;
            const [x, y] = this.getPos(e);
            this.ctx.beginPath();
            this.ctx.moveTo(this.lastX, this.lastY);
            this.ctx.lineTo(x, y);
            this.ctx.stroke();
            [this.lastX, this.lastY] = [x, y];
        },
        stopDrawing() {
            if (this.isDrawing) {
                this.isDrawing = false;
                this.save();
            }
        },
        getPos(e) {
            const rect = this.canvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return [clientX - rect.left, clientY - rect.top];
        },
        clear() {
            this.ctx.fillStyle = '{{ $backgroundColor }}';
            this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
            $wire.set('signature', null);
        },
        save() {
            $wire.set('signature', this.canvas.toDataURL('image/png'));
        }
    }"
    class="inline-block"
>
    <canvas
        x-ref="canvas"
        width="{{ $width }}"
        height="{{ $height }}"
        @mousedown="startDrawing($event)"
        @mousemove="draw($event)"
        @mouseup="stopDrawing()"
        @mouseleave="stopDrawing()"
        @touchstart.prevent="startDrawing($event)"
        @touchmove.prevent="draw($event)"
        @touchend="stopDrawing()"
        class="border border-gray-300 rounded-lg cursor-crosshair touch-none"
    ></canvas>
    <div class="mt-2 flex justify-end">
        <button
            type="button"
            @click="clear()"
            class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded transition-colors"
        >
            Clear
        </button>
    </div>
</div>
