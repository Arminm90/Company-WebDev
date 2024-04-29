<form data-url="<?= $frm_search_url ?>" id="frm_search" action="/search-results" method="GET">
      <input name="query" type="text" 
      placeholder="Search"
      oninput="search_users()"
      onfocus="document.querySelector('#query_results').classList.remove('hidden')"
      onblur="document.querySelector('#query_results').classList.add('hidden')"
      >
      <button>
        <span>
          search
        </span>            
      </button>
      <div id="query_results">        
      </div>
    </form>