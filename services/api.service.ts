

export const AgentService = {
  async post(method: any, path: string, body?: any) {
    const apiBase = import.meta.env.AGENT_BASE_URL;
    const url = `${apiBase}${path}`;
    // const token = useCookie("token");
    const headers = {
      "Content-Type": "application/json",

    };
    // Fetch options
    const options = {
      method: (typeof method === 'string' ? method.toUpperCase() : method), // Specify the HTTP method (GET, POST, PUT, DELETE, etc.)
      headers: headers,
      body: JSON.stringify(body), // Convert the request data to a JSON string
    };
    const response = await fetch(url, options);
    const data = await response.json();
    return data;
  },
};