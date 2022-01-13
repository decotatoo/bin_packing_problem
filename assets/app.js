/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// import './styles/app.css';


// start the Stimulus application
import './bootstrap';

import * as THREE from 'three';

const mainEl = document.getElementById('main');

let elWidth = mainEl.clientWidth;
let elHeight = window.innerHeight; //mainEl.clientHeight;


import { TrackballControls } from "three/examples/jsm/controls/TrackballControls.js";

let perspectiveCamera, orthographicCamera, controls, scene, renderer, stats;

const params = {
    orthographicCamera: false
};

const frustumSize = 400;


/**
 * X: width
 * Y: length
 * Z: depth.
 */


const aspect = elWidth / elHeight;

perspectiveCamera = new THREE.PerspectiveCamera(60, aspect, 1, 5000);
perspectiveCamera.position.z = 500;

orthographicCamera = new THREE.OrthographicCamera(frustumSize * aspect / - 2, frustumSize * aspect / 2, frustumSize / 2, frustumSize / - 2, 1, 1000);
orthographicCamera.position.z = 500;

// world

scene = new THREE.Scene();
scene.background = new THREE.Color(0xcccccc);
// scene.fog = new THREE.FogExp2(0xcccccc, 0.001);


// 
const packed = results.packed;

let row_x = 0;

console.log(packed);

results.packed.forEach(packed => {

    console.log(packed);

    const master = packed.box;

    const pos = createMasterObject(master);

    const items = packed.items;

    items.forEach((unit, index) => {
        createUnitObject(unit, pos);
    });


    row_x += (master.outer_length + 100);
});

// lights

const dirLight1 = new THREE.DirectionalLight(0xffffff);
dirLight1.position.set(1, 1, 1);
scene.add(dirLight1);

const dirLight2 = new THREE.DirectionalLight(0x002288);
dirLight2.position.set(- 1, - 1, - 1);
scene.add(dirLight2);

const ambientLight = new THREE.AmbientLight(0x222222);
scene.add(ambientLight);

// axis helper
const axesHelper = new THREE.AxesHelper(5000);
scene.add(axesHelper);

// renderer

renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(elWidth, elHeight);
// document.body.appendChild(renderer.domElement);

const simulationWrapperEl = document.createElement('div');
simulationWrapperEl.id = 'simulation-wrapper';
simulationWrapperEl.style.maxWidth = '100%';

simulationWrapperEl.appendChild(renderer.domElement);
mainEl.after(simulationWrapperEl);

window.addEventListener('resize', onWindowResize);

createControls(perspectiveCamera);

animate();






function createMasterObject(master) {
    const outer_trans_x = master.outer_width / 2;
    const outer_trans_y = master.outer_length / 2;
    const outer_trans_z = master.outer_depth / 2;

    const inner_trans_x = row_x + ((master.outer_width - master.inner_width) / 2);
    const inner_trans_y = (master.outer_length - master.inner_length) / 2;
    const inner_trans_z = (master.outer_depth - master.inner_depth) / 2;

    // create outer box
    const outer_geometry = new THREE.BoxGeometry(master.outer_width, master.outer_length, master.outer_depth);
    outer_geometry.translate(outer_trans_x, outer_trans_y, outer_trans_z);
    outer_geometry.translate(row_x, 0, 0);
    const outer_edge = new THREE.EdgesGeometry(outer_geometry);
    const outer_line = new THREE.LineSegments(outer_edge, new THREE.LineBasicMaterial({ color: 0xffffff }));
    outer_line.updateMatrix();
    outer_line.matrixAutoUpdate = true;


    // create inner box
    const inner_geometry = new THREE.BoxGeometry(master.inner_width, master.inner_length, master.inner_depth);
    inner_geometry.translate(master.inner_width / 2, master.inner_length / 2, master.inner_depth / 2);
    inner_geometry.translate(inner_trans_x, inner_trans_y, inner_trans_z);
    const inner_edge = new THREE.EdgesGeometry(inner_geometry);
    const inner_line = new THREE.LineSegments(inner_edge, new THREE.LineBasicMaterial({ color: 0x000000 }));
    inner_line.updateMatrix();
    inner_line.matrixAutoUpdate = true;

    scene.add(outer_line);
    scene.add(inner_line);

    return {
        outer: {
            x: outer_trans_x,
            y: outer_trans_y,
            z: outer_trans_z
        },
        inner: {
            x: inner_trans_x,
            y: inner_trans_y,
            z: inner_trans_z
        },
    }
}

function createUnitObject(item, pos) {
    /**
     * X: width
     * Y: length
     * Z: depth.
     */
    const geometry = new THREE.BoxGeometry(item.width, item.length, item.depth);
    geometry.translate(item.width / 2, item.length / 2, item.depth / 2);
    geometry.translate(
        pos.inner.x + item.x,
        pos.inner.y + item.y,
        pos.inner.z + item.z
    );
    // const material = new THREE.MeshBasicMaterial( {color: 0x00ff00} );

    const material = new THREE.MeshStandardMaterial({
        color: stringToColour(item.id),
        roughness: 0.1,
        metalness: 0.1,
        transparent: true,
        opacity: 0.3
    });
    const mesh = new THREE.Mesh(geometry, material);

    const edge = new THREE.EdgesGeometry(geometry);
    const line = new THREE.LineSegments(edge, new THREE.LineBasicMaterial({ color: 0xffffff }));
    line.updateMatrix();
    line.matrixAutoUpdate = true;

    scene.add(mesh);
    scene.add(line);
}

function stringToColour(str) {
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    let colour = '#';
    for (let i = 0; i < 3; i++) {
        let value = (hash >> (i * 8)) & 0xFF;
        colour += ('00' + value.toString(16)).substr(-2);
    }
    return colour;
}

function createControls(camera) {
    controls = new TrackballControls(camera, renderer.domElement);

    controls.rotateSpeed = 1.0;
    controls.zoomSpeed = 0.5;
    controls.panSpeed = 0.8;

    controls.keys = ['KeyA', 'KeyS', 'KeyD'];

}

function onWindowResize() {
    const aspect = elWidth / elHeight;

    perspectiveCamera.aspect = aspect;
    perspectiveCamera.updateProjectionMatrix();

    orthographicCamera.left = - frustumSize * aspect / 2;
    orthographicCamera.right = frustumSize * aspect / 2;
    orthographicCamera.top = frustumSize / 2;
    orthographicCamera.bottom = - frustumSize / 2;
    orthographicCamera.updateProjectionMatrix();

    renderer.setSize(elWidth, elHeight);

    controls.handleResize();
}

function animate() {
    requestAnimationFrame(animate);

    controls.update();

    render();

}

function render() {

    const camera = (params.orthographicCamera) ? orthographicCamera : perspectiveCamera;

    renderer.render(scene, camera);

}
