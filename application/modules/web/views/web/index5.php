<style>
    body, html, #app {
        margin: 0;
        width: 100%;
        height: 100%;
    }

    body {
        touch-action: none;
    }

    #app {
        height: 100%;
        font-family: "Montserrat", serif;
    }

    #canvas {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
    }

    a {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        text-decoration: none;
        text-shadow: 1px 1px 2px black;
    }
    #toggleLiquid {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10;
        padding: 10px 16px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 6px;
        cursor: pointer;
        font-family: inherit;
    }

</style>
<div id="app" >
    <button id="toggleLiquid">Disable Liquid</button>
    <canvas id="canvas"></canvas>
</div>
<script type="module">
    import LiquidBackground from 'https://cdn.jsdelivr.net/npm/threejs-components@0.0.27/build/backgrounds/liquid1.min.js';

    const app = LiquidBackground(document.getElementById('canvas'));

    /* background warna solid */
    function colorTexture(color) {
        const c = document.createElement('canvas');
        c.width = c.height = 1;
        const ctx = c.getContext('2d');
        ctx.fillStyle = color;
        ctx.fillRect(0, 0, 1, 1);
        return c.toDataURL();
    }

    app.loadImage(colorTexture('#1a1f2e'));

    app.liquidPlane.material.metalness = 0.6;
    app.liquidPlane.material.roughness = 0.35;

    /* state */
    let liquidEnabled = true;
    const DEFAULT_DISPLACEMENT = 4;

    /* toggle logic */
    document.getElementById('toggleLiquid').addEventListener('click', () => {
        liquidEnabled = !liquidEnabled;

        if (liquidEnabled) {
            app.liquidPlane.uniforms.displacementScale.value = DEFAULT_DISPLACEMENT;
            app.setRain(true);
            app.start?.(); // optional (jika ada)
            toggleLiquid.textContent = 'Disable Liquid';
        } else {
            app.liquidPlane.uniforms.displacementScale.value = 0;
            app.setRain(false);
            app.stop?.(); // optional (jika ada)
            toggleLiquid.textContent = 'Enable Liquid';
        }
    });
</script>