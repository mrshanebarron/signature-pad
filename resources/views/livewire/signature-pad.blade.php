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
            this.ctx.strokeStyle = '{{ $this->strokeColor }}';
            this.ctx.lineWidth = {{ $this->strokeWidth }};
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
            this.ctx.fillStyle = '{{ $this->backgroundColor }}';
            this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
            $wire.set('signature', null);
        },
        save() {
            $wire.set('signature', this.canvas.toDataURL('image/png'));
        }
    }"
    style="display: inline-block;"
>
    <canvas
        x-ref="canvas"
        width="{{ $this->width }}"
        height="{{ $this->height }}"
        @mousedown="startDrawing($event)"
        @mousemove="draw($event)"
        @mouseup="stopDrawing()"
        @mouseleave="stopDrawing()"
        @touchstart.prevent="startDrawing($event)"
        @touchmove.prevent="draw($event)"
        @touchend="stopDrawing()"
        style="border: 1px solid #d1d5db; border-radius: 8px; cursor: crosshair; touch-action: none;"
    ></canvas>
    <div style="margin-top: 8px; display: flex; justify-content: flex-end;">
        <button
            type="button"
            @click="clear()"
            style="padding: 6px 12px; font-size: 14px; color: #4b5563; background: transparent; border: none; cursor: pointer; border-radius: 4px; transition: background 0.15s;"
            onmouseover="this.style.background='#f3f4f6'; this.style.color='#111827'"
            onmouseout="this.style.background='transparent'; this.style.color='#4b5563'"
        >
            Clear
        </button>
    </div>
</div>
