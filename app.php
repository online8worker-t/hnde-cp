<?php
session_start();

// 🚫 Redirect to login page if user is not logged in
// if (!isset($_SESSION['user'])) {
//     header("Location: login?c=back"); // or wherever your login form is
//     exit;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="Make a cover page for your assignments, practicals or experiments. A cover page can be generated for assignments, practicals and experiments. Made for HNDE students in Sri Lanka.">
    <meta name="keywords" content="HNDE, hnde, cover page, ravindu, madhushankha, gdoop, assignments, practicals, experiments">
    <link rel="canonical" href="https://gdoop.us/hnde-cp/">

    <?php include_once('group-links.php'); ?>


    <title>HNDE Cover Page Maker - Create your report more easier for assignments, practicals and experiments.</title>

</head>

<body>
    <?php require_once 'header.php' ?>

    <main>
        <style>
            .form-container {
                margin: 0 auto;
                max-width: 700px;
            }

            .form {
                display: flex;
                flex-direction: column;
                width: 100%;
                padding: 1rem;
                border: 1px solid var(--field-bg-color);
                margin-top: 1rem;
                margin-bottom: 2rem;
                border-radius: 1rem;
            }

            h1 {
                text-align: center;
                font-size: 24px;
                margin-bottom: 20px;
            }

            label {
                font-size: 14px;
                display: block;
                margin-bottom: 0.2rem;
                color: var(--font-color-0);
            }

            input,
            select {
                margin-bottom: 0.5rem !important;
            }

            button {
                width: 100%;
                padding: 12px;
                font-size: 16px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn-0 {
                margin-left: 0 !important;
            }

            form .btn-4 {
                padding: 0.7rem 1rem;
                font-size: 1em;
            }

            .text-input {
                width: 100%;
                border: 2px solid var(--border-color-0);
                padding: 0.5rem;
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                outline: none;
                font-size: 1em;
                font-weight: 600;
                background-color: var(--field-bg-color);
                margin: 0.2rem 0 0.5rem 0;
                border-radius: var(--border-radius-0);
                color: var(--font-color-0);
            }
        </style>
        <div class="form-container">
            <form class="form" id="form">

                <h1 class="intro-title" style="font-size: 1.2em; padding-bottom: 1rem;"><i class="fa fa-eye" aria-hidden="true" onclick="pagePreview()"></i></h1>

                <label for="type">Type</label>
                <select name="type" id="type">
                    <option value="ASSIGNMENT">Assigment</option>
                    <option value="EXPERIMENT">Experiment</option>
                    <option value="PRACTICAL">Practical</option>
                    <option value="PROJECT">Project</option>
                </select>

                <label for="no">Number</label>
                <select name="no" id="no">
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                </select>

                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject">

                <label for="subject-code">Subject code</label>
                <input type="text" id="subject-code" name="subject-code">

                <br>
                <br>

                <label for="title">Title</label>
                <input type="text" id="title" name="title">

                <label for="instructor">Instructor</label>
                <input type="text" id="instructor" name="instructor" placeholder="MRS. A.B. RATHNAYAKE">

                <label for="group">Group</label>
                <input type="text" id="group" name="group" placeholder="C05">

                <label for="members">Group Members (comma separated)</label>
                <input type="text" id="members" name="members" placeholder="011,014,134,152">

                <br>
                <br>

                <div style="display: none;">
                    <label for="regNo">Registration Number</label>
                    <input type="text" id="regNo" name="regNo" value="" placeholder="COL/CE/2020/F/XXX" required disabled>

                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="" placeholder="A.B.C. PERERA" disabled>

                    <label for="course">Course</label>
                    <input type="text" id="course" name="course" value="" placeholder="Course" disabled>
                </div>

                <label for="regNo">Registration Number</label>
                <p class="text-input regNo" name="regNo"></p>

                <label for="name">Name</label>
                <p class="text-input name" name="name"></p>

                <label for="course">Course</label>
                <p class="text-input course" name="course"></p>

                <label for="dateOfIns">Date of Instruction</label>
                <input type="date" name="dateOfIns" id="dateOfIns">

                <label for="dateOfSub">Date of Submission</label>
                <input type="date" id="dateOfSub" name="dateOfSub">

                <br>
                <br>

                <button type="submit" class="btn btn-4">Download PDF</button>
                <br>
            </form>
        </div>
        <?php include_once('footer.php') ?>

        <section id="section-1">
            <div class="container">
                <img class="cover-page" src="./assets/cover-page_.png" alt="cover-page">
                <svg onclick="closePagePreview()" class="close-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path class="close-icon-path" fill="#000" d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
                </svg>
            </div>
        </section>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="./index.js?c=<?php echo uniqid('') ?>"></script>

    </main>

    <script>
        // Get the unique_key from localStorage
        const userData = JSON.parse(localStorage.getItem('userData') || '{}');
        const uniqueKey = userData.unique_key;

        // If not found, redirect to login page
        if (!uniqueKey) {
            window.location.href = 'login?c=back'; // Adjust path if needed
        }
    </script>

    <script>
        const data = JSON.parse(localStorage.getItem('userData') || '{}');
        const userDiv = document.getElementById('userData');

        document.querySelector('.regNo').textContent = data.registration_number;
        document.querySelector('.name').textContent = data.full_name;
        document.querySelector('.course').textContent = data.course;

        document.querySelector('#regNo').value = data.registration_number;
        document.querySelector('#name').value = data.full_name;
        document.querySelector('#course').value = data.course;

        if (!data || !data.unique_key) {
            userDiv.innerHTML = "<p>Unauthorized access. Please log in again.</p>";
        } else {
            userDiv.innerHTML = `
        <p><strong>Key:</strong> ${data.unique_key}</p>
        <p><strong>Status:</strong> ${data.status}</p>
        <p><strong>Other Data:</strong> ${data.other_data ?? 'N/A'}</p>
      `;
        }
    </script>

    <script>
/*
  DevTools deterrent script
  - Not foolproof. Determined users can bypass.
  - Customize `onDevToolsDetected()` to logout/redirect/clear page etc.
*/

// === Configuration ===
const DETECTION_POLL_MS = 1000;
const OUTER_INNER_THRESHOLD = 160; // px difference indicating docked devtools
const DEBUGGER_TIME_THRESHOLD = 100; // ms for timing-based debugger detection

// === Actions when devtools detected ===
function onDevToolsDetected() {
  // Example: show overlay and optionally redirect or reload
  showBlockingOverlay('Developer tools detected. Access denied.');
  // Optional: redirect after 2s
  // setTimeout(() => window.location.href = '/', 2000);
  // Optional: clear sensitive data, call logout endpoint, etc.
}

// === Overlay UI ===
function showBlockingOverlay(message) {
  if (document.getElementById('devtools-block-overlay')) return;
  const overlay = document.createElement('div');
  overlay.id = 'devtools-block-overlay';
  Object.assign(overlay.style, {
    position: 'fixed',
    inset: '0',
    background: 'rgba(0,0,0,0.95)',
    color: '#fff',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    zIndex: '2147483647',
    fontSize: '20px',
    textAlign: 'center',
    padding: '2rem'
  });
  overlay.innerHTML = `<div>${message}<br><small style="opacity:.8">If you believe this is an error contact support.</small></div>`;
  document.documentElement.appendChild(overlay);
}

// === Prevent context menu (right click) ===
window.addEventListener('contextmenu', e => {
  e.preventDefault();
}, { capture: true });

// === Block common keyboard shortcuts used to open DevTools / view source ===
window.addEventListener('keydown', e => {
  // F12
  if (e.key === 'F12') {
    e.preventDefault();
    e.stopPropagation();
    return false;
  }

  // Ctrl/Cmd + Shift + I/J/C  (Inspect / Console / DevTools)
  if ((e.ctrlKey || e.metaKey) && e.shiftKey && ['I','i','J','j','C','c'].includes(e.key)) {
    e.preventDefault();
    e.stopPropagation();
    return false;
  }

  // Ctrl/Cmd + U (view-source)
  if ((e.ctrlKey || e.metaKey) && (e.key === 'u' || e.key === 'U')) {
    e.preventDefault();
    e.stopPropagation();
    return false;
  }
}, { capture: true });

// === DevTools detection heuristics ===

// 1) Check difference between outer and inner dimensions (when devtools docked)
function detectUsingDimensions() {
  try {
    const widthDiff = Math.abs(window.outerWidth - window.innerWidth);
    const heightDiff = Math.abs(window.outerHeight - window.innerHeight);
    return widthDiff > OUTER_INNER_THRESHOLD || heightDiff > OUTER_INNER_THRESHOLD;
  } catch (err) {
    return false;
  }
}

// 2) Timing-based detection using 'debugger' (can detect if debugger is attached)
function detectUsingDebuggerTiming() {
  const start = performance.now();
  // NOTE: the `debugger` statement will pause script execution if the devtools debugger is actively interrupting.
  // Some browsers/conditions won't pause, so we use timing as a heuristic.
  // We wrap in try/catch to avoid throwing in some environments.
  try {
    // eslint-disable-next-line no-debugger
    debugger;
  } catch (e) {
    // ignore
  }
  const elapsed = performance.now() - start;
  return elapsed > DEBUGGER_TIME_THRESHOLD;
}

// 3) Open a console and check toString trick (less reliable, may cause console noise)
function detectUsingConsoleOpen() {
  // This prints a specially-crafted object; some browsers add extra properties when console is open.
  // We'll use a small known trick with a getter.
  let detected = false;
  const element = new Image();
  Object.defineProperty(element, 'id', {
    get: function() {
      detected = true;
      return 'devtools-detect';
    }
  });
  console.log(element);
  return detected;
}

// Polling loop
let devtoolsDetected = false;
const poll = setInterval(() => {
  if (devtoolsDetected) return;

  const dim = detectUsingDimensions();
  const dt = detectUsingDebuggerTiming();
  const cons = detectUsingConsoleOpen();

  if (dim || dt || cons) {
    devtoolsDetected = true;
    clearInterval(poll);
    try { onDevToolsDetected(); } catch (e) { /* ignore */ }
  }
}, DETECTION_POLL_MS);

// Optional: run once on load as well
window.addEventListener('load', () => {
  setTimeout(() => {
    if (!devtoolsDetected && (detectUsingDimensions() || detectUsingDebuggerTiming() || detectUsingConsoleOpen())) {
      devtoolsDetected = true;
      clearInterval(poll);
      onDevToolsDetected();
    }
  }, 500);
});
</script>


</body>

</html>